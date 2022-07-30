<?php

namespace App\Http\Livewire\Backend\Admin\Users;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithFileUploads;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $state = [];

    public $photo;

    public $user;

	public $showEditModal = false;

	public $userIdBeingRemoved = null;

    public $searchTerm = null;

    protected $queryString = ['searchTerm' => ['except' => '']];

    public $sortColumnName = 'name';

    public $sortDirection = 'asc';

    public $roleFilter = null;
    protected $userCount = Null;
    protected $roleUserCount = Null;
    protected $roleAdminCount = Null;
    protected $roleSuperadminCount = Null;

    public $user_permissions = [];

    public $showPermissions = true;

    // Update User Role

    public function updateUserRole(User $user ,$role)
    {
        Validator::make(['role' => $role],[
            'role' => 'required|in:1,2,3',
        ])->validate();

        $user->roles()->sync($role);

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'User role updated.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);
    }

    // Open Modal form to Add New User

    public function addNewUser()
    {
        $this->reset();

        $this->showEditModal = false;

        $this->dispatchBrowserEvent('show-form');
    }

    // store New User

    public function createUser()
    {
        $validatedData = Validator::make($this->state, [
			'name' => 'required',
			'username' => 'required|unique:users',
			'email' => 'required|email|unique:users',
			'mobile' => 'required|numeric|unique:users',
			'password' => 'required|confirmed',
            'role_id'   => 'required',
		])->validate();

		$validatedData['password'] = bcrypt($validatedData['password']);

		if ($this->photo) {
			$validatedData['profile_photo_path'] = $this->photo->store('/', 'profile_photos');
		}

        $user_permissions = [];
        for ($i=0; $i <  count($this->user_permissions); $i++) {
            $permission_value = array_values($this->user_permissions);
            if ($permission_value[$i] != false) {
                array_push($user_permissions, $permission_value[$i]);
            }
        }

		$user = User::create($validatedData);
        $user->attachRole($this->state['role_id']);
        $user->permissions()->attach($user_permissions);

        $this->dispatchBrowserEvent('hide-form');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'User Added Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
    }

    public function permissions_form($role)
    {
        if ($role == 1 or $role == 2) {
            $this->showPermissions = true;
        } else {
            $this->showPermissions = false;
        }
    }

    // Open Modal form to update User

    public function edit(User $user)
    {
        $this->reset();

		$this->showEditModal = true;

		$this->user = $user;

		$this->state = $user->toArray();

        $this->state['role_id'] = $user->roles[0]->id;

        if ($this->state['role_id']==3) {
            $this->showPermissions = false;
        }

        $this->user_permissions = $user->permissions()->pluck('id','permission_id')->toArray();

		$this->dispatchBrowserEvent('show-form');
    }

    // Update User

    public function updateUser()
	{
        //dd($this->user_permissions,$this->user->permissions());

		$validatedData = Validator::make($this->state, [
			'name'      => 'required',
            'username'  => 'required|unique:users,username,'.$this->user->id,
			'email'     => 'required|email|unique:users,email,'.$this->user->id,
			'mobile'    => 'required|numeric|unique:users,mobile,'.$this->user->id,
            'role_id'   => 'required',
			'password'  => 'sometimes|confirmed',
		])->validate();

		if(!empty($validatedData['password'])) {
			$validatedData['password'] = bcrypt($validatedData['password']);
		}

		if ($this->photo) {
            if($this->user->profile_photo_path){
                Storage::disk('profile_photos')->delete($this->user->profile_photo_path);
            }
			$validatedData['profile_photo_path'] = $this->photo->store('/', 'profile_photos');
		}

        $user_permissions = [];
        for ($i=0; $i <  count($this->user_permissions); $i++) {
            $permission_value = array_values($this->user_permissions);
            if ($permission_value[$i] != false) {
                array_push($user_permissions, $permission_value[$i]);
            }
        }

        //dd($this->state['role_id'],$user_permissions);

		$this->user->update($validatedData);
        $this->user->roles()->sync($this->state['role_id']);
        $this->user->permissions()->sync($user_permissions);

		$this->dispatchBrowserEvent('hide-form');

        $this->dispatchBrowserEvent('swal', [
            'title'         => 'User updated Successfully.',
            'icon'          =>'success',
            'iconColor'     => 'green',
            'position'      => 'center',
            'timer'         => '1700',
        ]);
	}

    // Show Modal Form to Confirm User Removal

    public function confirmUserRemoval($userId)
	{
		$this->userIdBeingRemoved = $userId;

		$this->dispatchBrowserEvent('show-delete-modal');
	}

    // Delete User

	public function deleteUser()
	{
		$user = User::findOrFail($this->userIdBeingRemoved);

		$user->delete();

		$this->dispatchBrowserEvent('hide-delete-modal');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'User Deleted Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
	}

    // Sort By Column Name

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;

    }

    // Swap Sort Direction

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    // Updated Search Term

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    //  Filter Users By Roles

    public function filterUsersByRoles($roleFilter = null)
    {
        $this->roleFilter = $roleFilter;
    }

    // Render date to list-users Blade

    public function render()
    {
        $userCount= User::count();
        $roleUserCount= User::whereRelation('roles', 'name', 'user')->count();
        $roleAdminCount= User::whereRelation('roles', 'name', 'admin')->count();
        $roleSuperadminCount= User::whereRelation('roles', 'name', 'superadmin')->count();

        $roles = Role::all();
        $permissions = Permission::all();

        if ($this->roleFilter) {
            $users = User::whereRelation('roles', 'name',$this->roleFilter )
            ->where('name', 'like', '%'.$this->searchTerm.'%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(15);
        } else {
            $users = User::query()
            ->where('name', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('username', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('email', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('mobile', 'like', '%'.$this->searchTerm.'%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(15);
        }

        return view('livewire.backend.admin.users.list-users',[
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions,
            'userCount' => $userCount,
            'roleUserCount' => $roleUserCount,
            'roleAdminCount' => $roleAdminCount,
            'roleSuperadminCount' => $roleSuperadminCount
        ])->layout('layouts.admin');
    }
}

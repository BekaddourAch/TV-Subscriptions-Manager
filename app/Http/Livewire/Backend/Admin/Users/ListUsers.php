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
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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

    public $selectedRows = [];

	public $selectPageRows = false;

    protected $listeners = ['deleteConfirmed' => 'deleteUsers'];

    public $excelFile = Null;

    public $importTypevalue = 'addNew';

    // Updated Select Page Rows

    public function updatedSelectPageRows($value)
	{
		if ($value) {
			$this->selectedRows = $this->users->pluck('id')->map(function ($id) {
				return (string) $id;
			});
		} else {
			$this->reset(['selectedRows', 'selectPageRows']);
		}
	}

    // Get Users Data

    public function getUsersProperty()
	{
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

        return $users;
	}

    // set All selected User As Active

    public function setAllAsActive()
	{
		User::whereIn('id', $this->selectedRows)->update(['status' => 1]);

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'Users set As Active successfully.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

		$this->reset(['selectPageRows', 'selectedRows']);
	}

    // set All selected User As InActive

	public function setAllAsInActive()
	{
		User::whereIn('id', $this->selectedRows)->update(['status' => 0]);

		$this->dispatchBrowserEvent('swal', [
            'title'             => 'Users set As Inactive successfully.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

		$this->reset(['selectPageRows', 'selectedRows']);
	}

    // show Sweetalert Confirmation for Delete

	public function deleteSelectedRows()
	{
        $this->dispatchBrowserEvent('show-delete-alert-confirmation');
	}

    // Delete Selected User with relationship roles And permission

    public function deleteUsers()
    {
        // delete images for users if exists from Storage folder
        $profileImages =User::whereIn('id', $this->selectedRows)->get(['profile_photo_path']);
        foreach($profileImages as $profileImage){
            $imageFileName = $profileImage->profile_photo_path;
            if($imageFileName){
                Storage::disk('profile_photos')->delete($imageFileName);
            }
        }

        // delete roles and permissions for selected users from database
        DB::table('role_user')->whereIn('user_id', $this->selectedRows)->delete();
        DB::table('permission_user')->whereIn('user_id', $this->selectedRows)->delete();

        // delete selected users from database
		User::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('swal', [
            'title'             => 'All selected users got deleted.',
            'icon'              =>'success',
            'iconColor'         => 'green',
            'position'          => 'center',
            'timer'             => '1700',
        ]);

		$this->reset();
    }

    // Update User Role

    public function updateUserRole(User $user ,$role)
    {
        Validator::make(['role' => $role],[
            //'role' => 'required|in:1,2,3',
            'role' => 'required',
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
        if ($role <> 3) {
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
        try {
            $validatedData = Validator::make($this->state, [
                'name'                  => 'required',
                'username'              => 'required|unique:users,username,'.$this->user->id,
                'email'                 => 'required|email|unique:users,email,'.$this->user->id,
                'mobile'                => 'required|numeric|unique:users,mobile,'.$this->user->id,
                'role_id'               => 'required',
                'password'              => 'sometimes|confirmed',
                'photo'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
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

    // Export Excel File

    public function exportExcel()
    {
        return Excel::download(new UsersExport($this->searchTerm,$this->selectedRows), 'users.xlsx');
    }

    // Show Import Excel Form

    public function importExcelForm()
    {
        $this->reset();
		$this->dispatchBrowserEvent('show-import-excel-modal');
    }

    public function importType($value)
    {
        $this->importTypevalue = $value;
    }

    public function importExcel()
    {
        try {

            $this->validate([
                'excelFile' => 'mimes:xls,xlsx'
            ]);

            if ($this->importTypevalue == 'addNew') {
                // for add new data
                Excel::import(new UsersImport, $this->excelFile);
            } else {
                // for update data
                $this->importTypevalue = 'Update';
                $usersData = Excel::toCollection(new UsersImport(), $this->excelFile);
                foreach ($usersData[0] as $user) {
                    User::where('id', $user['id'])->update([
                        'name' => $user['name'],
                        'username' => $user['username'],
                        'mobile' => $user['mobile'],
                        'email' => $user['email'],
                        'password' => bcrypt($user['password']),
                    ]);
                }
            }

            // method for add Roles to nwe users added

            $usersDoesntHaveRole = User::whereDoesntHave('roles')->get();

            foreach ($usersDoesntHaveRole as $user) {
                DB::table('role_user')->insert([
                    'role_id' => 3,
                    'user_id' => $user->id,
                    'user_type' => 'App\Models\User'
                ]);
            }

            // end method

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Users Added Successfully.',
                'icon'=>'success',
                'iconColor' => 'green',
                'position' => 'center',
                'timer' => '1700',
            ]);

            $this->dispatchBrowserEvent('hide-import-excel-modal');


        } catch (\Exception $e) {
            //return $e->getMessage();
            $this->dispatchBrowserEvent('swal', [
                'title' =>  'ملف الإكسل غير مطابق !!',
                'icon'=>'error',
                'iconColor' => 'red',
                'position' => 'center',
                'timer' => '1700',
            ]);

            $this->reset();
            $this->dispatchBrowserEvent('hide-import-excel-modal');
        }
    }

    // Export PDF File

    public function exportPDF()
    {
        return response()->streamDownload(function(){
            if ($this->selectedRows) {
                $users = User::whereIn('id', $this->selectedRows)->orderBy('name', 'asc')->get();
            } else {
                $users = $this->users;
            }

            $pdf = PDF::loadView('livewire.backend.admin.users.pdf',['users' => $users]);
            return $pdf->stream('users');

        },'users.pdf');
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

        $users = $this->users;

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

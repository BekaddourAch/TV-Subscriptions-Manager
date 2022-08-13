<?php

namespace App\Http\Livewire\Backend\Admin\Users;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class ListRoles extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $role;

	public $showEditModal = false;

	public $roleIdBeingRemoved = null;

    public $role_permissions = [];

    protected $listeners = ['deleteConfirmed' => 'deleteRoles'];

    public function addNewRole()
    {
        $this->reset();

        $this->showEditModal = false;

        $this->dispatchBrowserEvent('show-form');
    }

    public function createRole()
    {
        $validatedData = Validator::make($this->data, [
			'name' => 'required|unique:roles',
			'display_name' => 'required|unique:roles',
			'description' => 'required',
		])->validate();

        $role_permissions = [];
        for ($i=0; $i <  count($this->role_permissions); $i++) {
            $permission_value = array_values($this->role_permissions);
            if ($permission_value[$i] != false) {
                array_push($role_permissions, $permission_value[$i]);
            }
        }

		$role = Role::create($validatedData);
        $role->permissions()->attach($role_permissions);

        $this->dispatchBrowserEvent('hide-form');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Role Added Successfully.',
            'icon'=>'success',
            'iconColor' => 'green',
            'position' => 'center',
            'timer' => '1700',
        ]);
    }

    public function edit(Role $role)
    {
        $this->reset();

		$this->showEditModal = true;

        $this->data = $role->toArray();

		$this->role = $role;

        $this->role_permissions = $role->permissions()->pluck('id','permission_id')->toArray();

		$this->dispatchBrowserEvent('show-form');
    }

    public function updateRole()
	{
        try {
            $validatedData = Validator::make($this->data, [
                'name'              => 'required|unique:roles,name,'.$this->role->id,
                'display_name'      => 'required|unique:roles,display_name,'.$this->role->id,
                'description'       => 'required',
            ])->validate();

            $role_permissions = [];
            for ($i=0; $i <  count($this->role_permissions); $i++) {
                $permission_value = array_values($this->role_permissions);
                if ($permission_value[$i] != false) {
                    array_push($role_permissions, $permission_value[$i]);
                }
            }

            $this->role->update($validatedData);
            $this->role->permissions()->sync($role_permissions);

            $this->dispatchBrowserEvent('hide-form');

            $this->dispatchBrowserEvent('swal', [
                'title'         => 'Role updated Successfully.',
                'icon'          =>'success',
                'iconColor'     => 'green',
                'position'      => 'center',
                'timer'         => '1700',
            ]);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
	}

// Show Modal Form to Confirm Role Removal

public function confirmRoleRemoval($roleId)
{
    $this->roleIdBeingRemoved = $roleId;

    $this->dispatchBrowserEvent('show-delete-modal');
}

// Delete Role

public function deleteRole()
{
    $role = Role::findOrFail($this->roleIdBeingRemoved);

    $role->delete();

    $this->dispatchBrowserEvent('hide-delete-modal');

    $this->dispatchBrowserEvent('swal', [
        'title' => 'Role Deleted Successfully.',
        'icon'=>'success',
        'iconColor' => 'green',
        'position' => 'center',
        'timer' => '1700',
    ]);
}


    public function render()
    {
        $roles = Role::paginate(15);
        $permissions = Permission::all();

        return view('livewire.backend.admin.users.list-roles',[
            'roles' => $roles,
            'permissions' => $permissions,
        ])->layout('layouts.admin');
    }
}

<?php

namespace App\Http\Livewire\Backend\Admin\Users;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class ListPermissions extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $permission;

	public $showEditModal = false;

	public $permissionIdBeingRemoved = null;

    protected $listeners = ['deleteConfirmed' => 'deletePermissions'];

    public function addNewPermission()
    {
        $this->reset();

        $this->showEditModal = false;

        $this->dispatchBrowserEvent('show-form');
    }
 
    public function edit(Permission $permission)
    {
        if (Auth::user()->hasPermission('users-update')) {
        $this->reset();

		$this->showEditModal = true;

        $this->data = $permission->toArray();

		$this->permission = $permission;

		$this->dispatchBrowserEvent('show-form');
        }
    }

    public function updatePermission()
	{
        if (Auth::user()->hasPermission('users-update')) {
        try {
            $validatedData = Validator::make($this->data, [
                //'name'              => 'required|unique:permissions,name,'.$this->permission->id,
                'display_name'      => 'required|unique:permissions,display_name,'.$this->permission->id,
                'description'       => 'required',
            ])->validate();

            $permission_name = $validatedData['display_name'];
            $permission_name = strtolower($permission_name);
            $permission_name = explode(" ", $permission_name);
            $permission_name = $permission_name[1] . "-" . $permission_name[0];

            $validatedData['name'] = $permission_name ;

            $this->permission->update($validatedData);

            $this->dispatchBrowserEvent('hide-form');

            $this->dispatchBrowserEvent('swal', [
                'title'         => 'Permission updated Successfully.',
                'icon'          =>'success',
                'iconColor'     => 'green',
                'position'      => 'center',
                'timer'         => '1700',
            ]);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
	}

 

    public function render()
    {
        $permissions = Permission::paginate(15);
 
        // var_dump(count($permissions));
        return view('livewire.backend.admin.users.list-permissions',[
            'permissions' => $permissions,
        ])->layout('layouts.admin');
    }
}

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
                'name'              => 'required',
                'display_name'      => 'required',
                'description'       => '',
                'groupe'            => 'required',
            ])->validate();


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
        $permissions = Permission::paginate(10);

        // var_dump(count($permissions));
        return view('livewire.backend.admin.users.list-permissions',[
            'permissions' => $permissions,
        ])->layout('layouts.admin');
    }
}

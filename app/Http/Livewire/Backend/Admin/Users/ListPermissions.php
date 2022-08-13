<?php

namespace App\Http\Livewire\Backend\Admin\Users;

use Livewire\Component;
use App\Models\Permission;

class ListPermissions extends Component
{
    public function render()
    {
        $permissions = Permission::all();
        
        return view('livewire.backend.admin.users.list-permissions',[
            'permissions' => $permissions,
        ])->layout('layouts.admin');
    }
}

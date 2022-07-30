<?php

namespace App\Http\Livewire\Backend\Admin\Dashboard;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.dashboard.dashboard')->layout('layouts.admin');
    }
}

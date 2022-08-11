<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

class BackendController extends Controller
{
    public function login()
    {
        return view('backend.login');
    }

    public function index()
    {
        if (Auth::user()->hasRole('superadmin|admin')) {
            return view('backend.index');
        }
    }

    public function pdf()
    {
        $users = User::all();
        return view('livewire.backend.admin.users.pdf',['users'=> $users]);
    }

    public function make_pdf()
    {
        $users = User::all();

        $pdf = PDF::loadView('livewire.backend.admin.users.pdf',['users' => $users]);
        return $pdf->download('users.pdf');
    }
}

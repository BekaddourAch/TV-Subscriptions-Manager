<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}

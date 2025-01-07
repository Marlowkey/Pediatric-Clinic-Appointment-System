<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->role->name == 'admin') {
            return view('admin.pages.dashboard');
        } elseif ($user->role->name == 'doctor') {
            return view('pages.doctor-home');
        } elseif ($user->role->name == 'patient') {
            return view('pages.index');
        }

        return view('pages.index');
    }
}

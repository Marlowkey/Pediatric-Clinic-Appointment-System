<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role->name, ['admin', 'doctor'])) {
            return view('admin.pages.dashboard');
        }

        return view('pages.index');
    }
}

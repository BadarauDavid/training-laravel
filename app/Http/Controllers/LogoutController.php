<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        auth()->logout();

        session()->flash('success', 'You have been logged out');

        return redirect()->route('index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($credentials)) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email or password is incorrect']);
        }

        session()->regenerate();
        $message = __('You successfully logged in');
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['message' => $message]) : redirect()->route('products');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');


        if (!auth()->attempt($credentials)) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email or password is incorrect']);
        }

        $message = __('You successfully logged in');
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json([$message]) : redirect()->route('products');
    }
}

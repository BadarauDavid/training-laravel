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
        $email = $validatedData['email'];
        $password = $validatedData['password'];

        if (!auth()->attempt(['email' => $email, 'password' => $password])) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email or password is incorrect']);
        }

        session()->regenerate();
        session()->put('role', 'admin');

        $message = __('You successfully logged in');
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('index');
    }
}

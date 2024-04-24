<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        auth()->logout();

        $message = 'You have been logged out';
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('index');
    }
}

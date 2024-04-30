<?php

namespace App\Http\Controllers;

class LogoutController extends Controller
{
    public function logout()
    {
        auth()->logout();

        $message = __('You have been logged out');
        session()->flash('success', $message);

        return request()->isXmlHttpRequest() ?
            response()->json(['success' => $message]) : redirect()->route('index');
    }
}

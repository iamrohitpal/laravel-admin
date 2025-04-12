<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function logincheck(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $userCheck = User::where('email', $request->email)->first();
        if (Hash::check($request->password, $userCheck->password)) {
            Auth::guard('admin')->login($userCheck);

            return redirect()->route('dashboard')->with('success', 'Login Successfully!');
        } else {
            return redirect()->back()->with('error', 'Invalid Crtedentials!');
        }
    }

    public function forgot_password(Request $request)
    {
        return route('login');
    }
}

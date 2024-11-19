<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AdminAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('admin.register'); // Updated to point to the new view
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
            'institution_name' => 'required', // Always required
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $admin = Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'institution_id' => $request->institution_name, // Store the institution name directly
        ]);

        event(new Registered($admin));

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Registration successful! Please verify your email.');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login'); // Create this view
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('admin/dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}

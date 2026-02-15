<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Proses login admin (Laravel Auth + Supabase DB)
     */
    public function login(Request $request)
    {
        // Validasi (JANGAN pakai |email)
        $request->validate([
            'login'    => 'required',
            'password' => 'required'
        ]);

        $email = $request->login;
        $password = $request->password;

        // Cari admin berdasarkan email atau username
        $admin = DB::table('admin')
            ->where('email', $email)
            ->orWhere('username', $email)
            ->first();


        // Kalau email TIDAK ADA atau password SALAH
        if (!$admin || !Hash::check($password, $admin->password)) {
            return back()->withErrors([
                'login' => 'Email atau password salah.'
            ])->withInput();
        }

        // Simpan session
        Session::put('admin_logged_in', true);
        Session::put('admin_email', $admin->email);
        Session::put('admin_username', $admin->username);
        Session::put('admin_role', $admin->role);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

}

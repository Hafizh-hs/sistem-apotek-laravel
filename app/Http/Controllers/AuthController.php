<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Sangat penting agar fungsi Login jalan

class AuthController extends Controller
{
    public function halamanLogin()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        // Logika untuk memeriksa email dan password
        $kredensial = $request->only('email', 'password');

        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Mengarahkan ke login sambil memberi instruksi agar browser tidak menyimpan cache
    return redirect('/login')->withHeaders([
        'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
    ]);
}
}
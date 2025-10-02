<?php

namespace App\Http\Controllers;

use App\Helpers\ValidateHelp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    function loginView()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    function login(Request $request)
    {
        $request->validate(ValidateHelp::login());

        // 🔹 2. Cegah brute force dengan rate limiting
        $this->checkTooManyAttempts($request);

        // 🔹 3. Login
        if (!Auth::attempt($request->only('nip', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request)); // tambah hit
            throw ValidationException::withMessages([
                'nip' => 'NIP atau password salah.',
            ]);
        }

        // 🔹 4. Clear rate limiter setelah sukses login
        RateLimiter::clear($this->throttleKey($request));

        // 🔹 5. Redirect atau return response
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    function profileView(): View
    {
        return view('auth.profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }

    // Helper: cek percobaan berlebihan
    protected function checkTooManyAttempts(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan login. Coba lagi nanti.',
            ]);
        }
    }
}

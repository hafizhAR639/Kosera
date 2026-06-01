<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthRegistrationService;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthRegistrationService $registrationService)
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function showRegister()
    {
        return view('auth.register', ['title' => 'Register']);
    }

    public function login(\App\Http\Requests\LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('mitra.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);
        $validated['join_date'] = now();
        $validated['status'] = 'active';

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('mitra.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang!');
    }

    /**
     * Step-based registration flow used by routes/web.php (/register POST)
     */
    public function processStepRegistration(Request $request)
    {
        $input = $request->except('_token');
        $stored = session('register.data', []);

        $result = $this->registrationService->processStep($input, $stored);

        session(['register.data' => $result['stored']]);

        if (!empty($result['flash'])) {
            session()->flash('message', $result['flash']);
        }

        if (!empty($result['clear_session'])) {
            session()->forget('register.data');
        }

        return redirect()->route($result['redirect_route'], $result['redirect_params'] ?? []);
    }

    public function logout(Request $request)
    {
        $role = $request->user()?->role ?? null;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'mitra') {
            return redirect()->route('admin.welcome')
                ->with('success', 'Logout berhasil.');
        }

        return redirect()->route('welcome')
            ->with('success', 'Logout berhasil.');
    }
}

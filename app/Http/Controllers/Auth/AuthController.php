<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('mitra.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Logout berhasil.');
    }
}

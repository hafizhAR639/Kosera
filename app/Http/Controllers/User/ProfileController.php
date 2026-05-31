<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private UserProfileService $profileService) {}

    public function show()
    {
        $user = $this->profileService->getUserWithFallback(Auth::id(), 1);
        return view('user.profile', ['user' => $user]);
    }

    public function edit()
    {
        $user = $this->profileService->getUserWithFallback(Auth::id(), 1);
        return view('user.profile_edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = $this->profileService->getUserWithFallback(Auth::id(), 1);
        if (! $user) {
            return redirect()->route('user.dashboard');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $this->profileService->updateProfile($user, [
            'nama' => $validated['nama'],
            'phone' => $validated['phone'] ?? null,
            'location' => $validated['location'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('user.profile.show')
            ->with('message', ['type' => 'success', 'text' => 'Profil berhasil diperbarui.']);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserProfileService;
use App\Http\Requests\UserProfileRequest;
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

    public function update(UserProfileRequest $request)
    {
        $user = $this->profileService->getUserWithFallback(Auth::id(), 1);
        if (! $user) {
            return redirect()->route('user.dashboard');
        }

        $validated = $request->validated();

        $fullLocation = $validated['location'] ?? '';
        if (!empty($validated['address'])) {
            $fullLocation .= ' - ' . $validated['address'];
        }

        $this->profileService->updateProfile($user, [
            'nama' => $validated['nama'],
            'phone' => $validated['phone'] ?? null,
            'location' => $fullLocation,
        ]);

        return redirect()->route('user.profile.show')
            ->with('message', ['type' => 'success', 'text' => 'Profil berhasil diperbarui.']);
    }
}

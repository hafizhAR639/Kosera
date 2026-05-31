<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(private UserRepository $users) {}

    public function success()
    {
        $userId = Auth::id() ?? session('user_id', 1);
        $order = $this->users->latestOrderByUser((int) $userId);

        return view('user.payment-success', [
            'order' => $order,
        ]);
    }
}

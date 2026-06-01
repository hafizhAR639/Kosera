<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(\App\Http\Requests\RatingRequest $request)
    {
        $validated = $request->validated();

        session()->push('ratings', $validated);

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil disimpan',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user->load(['questions', 'friendships']);
        return response()->json(['data' => $user]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
        ]);

        $user = $request->user();
        $user->update($validated);

        return response()->json(['data' => $user]);
    }
}

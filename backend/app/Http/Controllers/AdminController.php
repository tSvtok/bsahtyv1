<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spot;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function banUser(Request $request, User $user)
    {
        $user->update(['is_banned' => true]);
        return response()->json(['message' => 'User banned successfully']);
    }

    public function unbanUser(Request $request, User $user)
    {
        $user->update(['is_banned' => false]);
        return response()->json(['message' => 'User unbanned successfully']);
    }

    public function approveSpot(Request $request, Spot $spot)
    {
        $spot->update(['status' => 'APPROVED']);
        return response()->json(['message' => 'Spot approved successfully']);
    }

    public function rejectSpot(Request $request, Spot $spot)
    {
        $spot->update(['status' => 'REJECTED']);
        return response()->json(['message' => 'Spot rejected successfully']);
    }
}

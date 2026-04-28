<?php

namespace App\Http\Controllers;

use App\Enums\FriendshipStatus;
use App\Http\Requests\StoreFriendshipRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $status = $request->input('status');
        
        // Get friendships
        $query = Friendship::with(['user', 'friend'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('friend_id', $user->id);
            });
        
        // Filter by status if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        $friendships = $query->get();

        return response()->json(['data' => $friendships]);
    }

    public function checkStatus(Request $request, $userId)
    {
        $currentUserId = $request->user()->id;
        
        $friendship = Friendship::where(function ($query) use ($currentUserId, $userId) {
            $query->where('user_id', $currentUserId)->where('friend_id', $userId);
        })->orWhere(function ($query) use ($currentUserId, $userId) {
            $query->where('user_id', $userId)->where('friend_id', $currentUserId);
        })->first();

        if (!$friendship) {
            return response()->json(['data' => ['status' => 'NONE']]);
        }

        return response()->json(['data' => $friendship]);
    }

    public function store(StoreFriendshipRequest $request)
    {
        $validated = $request->validated();
        $userId = $request->user()->id;
        $friendId = $validated['friend_id'];

        // Prevent self-friendship
        if ($userId === $friendId) {
            return response()->json(['message' => 'You cannot send a friend request to yourself.'], 400);
        }

        // Prevent duplicate requests
        $existing = Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        if ($existing) {
            return response()->json(['message' => 'Friendship already exists or is pending.'], 400);
        }

        $friendship = Friendship::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => FriendshipStatus::PENDING,
        ]);

        try {
            broadcast(new \App\Events\FriendRequestReceived($friendship))->toOthers();
        } catch (\Exception $e) {
            \Log::warning('Failed to broadcast friend request: ' . $e->getMessage());
        }

        return response()->json(['data' => $friendship], 201);
    }

    public function update(Request $request, Friendship $friendship)
    {
        $request->validate(['status' => 'required|string']);

        $status = $request->input('status');

        // Only the receiver can accept
        if ($status === FriendshipStatus::ACCEPTED->value && $request->user()->id !== $friendship->friend_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $friendship->update(['status' => $status]);

        return response()->json(['data' => $friendship]);
    }

    public function destroy(Request $request, Friendship $friendship)
    {
        if ($request->user()->id !== $friendship->user_id && $request->user()->id !== $friendship->friend_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $friendship->delete();
        return response()->json(null, 204);
    }
}

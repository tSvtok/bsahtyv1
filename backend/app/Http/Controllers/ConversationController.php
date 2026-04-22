<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $conversations = $request->user()->conversations()->with('users')->get();
        return response()->json(['data' => $conversations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $userIds = $request->user_ids;
        $userIds[] = $request->user()->id; // Include the creator
        $userIds = array_unique($userIds);

        $conversation = Conversation::create();
        $conversation->users()->attach($userIds);

        return response()->json($conversation->load('users'), 201);
    }

    public function show(Request $request, Conversation $conversation)
    {
        if (!$conversation->users()->where('user_id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation->load('messages.sender', 'users');
        return response()->json(['data' => $conversation]);
    }
}

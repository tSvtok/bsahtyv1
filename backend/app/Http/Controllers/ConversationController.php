<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $conversations = $user->conversations()
            ->with(['users', 'lastMessage'])
            ->get()
            ->map(function ($convo) use ($user) {
                $otherUser = $convo->users->where('id', '!=', $user->id)->first();
                $convo->other_user = $otherUser;
                $convo->unread_count = $convo->messages()
                    ->where('user_id', '!=', $user->id)
                    ->where('is_read', false)
                    ->count();
                return $convo;
            });

        return response()->json(['data' => $conversations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $userIds = $request->user_ids;
        $userIds[] = $request->user()->id;
        $userIds = array_unique($userIds);
        sort($userIds);

        // Check if a conversation already exists with the exact same users
        $existing = Conversation::whereHas('users', function ($q) use ($userIds) {
            $q->whereIn('users.id', $userIds);
        }, '=', count($userIds))
        ->has('users', count($userIds))
        ->first();

        if ($existing) {
            return response()->json($existing->load('users'));
        }

        $conversation = Conversation::create();
        $conversation->users()->attach($userIds);

        return response()->json($conversation->load('users'), 201);
    }

    public function show(Request $request, Conversation $conversation)
    {
        if (!$conversation->users()->where('user_id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation->load(['messages', 'users']);
        
        $otherUser = $conversation->users->where('id', '!=', $request->user()->id)->first();
        
        $data = $conversation->toArray();
        $data['other_user'] = $otherUser;

        return response()->json(['data' => $data]);
    }
}

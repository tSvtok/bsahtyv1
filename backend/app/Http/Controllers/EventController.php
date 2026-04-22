<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('questions')->latest()->paginate(15);
        return response()->json(['data' => $events]);
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        
        $event = Event::create($validated);

        if ($request->filled('question_id')) {
            $question = \App\Models\Question::find($request->question_id);
            if ($question) {
                $question->update(['event_id' => $event->id]);
            }
        }

        return response()->json(['data' => $event], 201);
    }

    public function show(Event $event)
    {
        $event->load('questions.user');
        return response()->json(['data' => $event]);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return response()->json(['data' => $event]);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }
}

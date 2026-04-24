<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Notifications\NewEventNotification;
use App\Notifications\NewParticipantNotification;

class EventController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Event::with('questions');

        if ($request->has('sport')) {
            $query->where('sport', $request->sport);
        }

        if ($request->has('city')) {
            $query->where('location', 'like', "%{$request->city}%");
        }

        if ($request->boolean('nearby') && auth('sanctum')->check()) {
            $userCity = auth('sanctum')->user()->city;
            if ($userCity) {
                $query->where(function($q) use ($userCity) {
                    $q->where('location', 'like', "%{$userCity}%")
                      ->orWhereHas('organizer', function($q) use ($userCity) {
                          $q->where('city', 'like', "%{$userCity}%");
                      });
                });
            }
        }

        $events = $query->latest()->paginate(15);
        return response()->json(['data' => $events]);
    }

    public function store(StoreEventRequest $request, \App\Services\MapService $mapService)
    {
        $validated = $request->validated();
        $validated['organizer_id'] = $request->user()->id;

        // Combine date and time
        if ($request->has('date') && $request->has('time')) {
            $validated['date'] = $request->date . ' ' . $request->time;
        }

        // Geocode location
        if ($request->filled('location')) {
            $coords = $mapService->geocodeAddress($request->location);
            if ($coords['lat'] !== 0.0) {
                $validated['latitude'] = $coords['lat'];
                $validated['longitude'] = $coords['lng'];
            }
        }

        $event = Event::create($validated);
        $event->load('organizer');

        try {
            broadcast(new \App\Events\EventCreated($event))->toOthers();
        } catch (\Exception $e) {
            \Log::error("Broadcasting failed: " . $e->getMessage());
        }

        // Notify friends
        $user = $request->user();
        try {
            $friendIds = \App\Models\Friendship::where(function($query) use ($user) {
                    $query->where('user_id', $user->id)->orWhere('friend_id', $user->id);
                })
                ->where('status', 'ACCEPTED')
                ->get()
                ->map(fn($f) => $f->user_id === $user->id ? $f->friend_id : $f->user_id)
                ->toArray();

            $friends = \App\Models\User::whereIn('id', $friendIds)->get();

            foreach ($friends as $friend) {
                $friend->notify(new \App\Notifications\NewEventNotification($event));
            }
        } catch (\Exception $e) {
            \Log::error("Friend notification failed: " . $e->getMessage());
        }

        return response()->json(['data' => $event], 201);
    }

    public function show(Event $event)
    {
        $event->load(['questions.user', 'participants', 'organizer']);
        return response()->json(['data' => $event]);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        if ($request->has('join')) {
            $user = $request->user();
            if ($request->join) {
                $event->participants()->syncWithoutDetaching([$user->id]);

                // Notify organizer
                if ($event->organizer_id !== $user->id) {
                    $event->organizer->notify(new NewParticipantNotification($event, $user));
                }
            } else {
                $event->participants()->detach($user->id);
            }

            event(new \App\Events\EventParticipantsUpdated($event));

            return response()->json(['data' => $event->load('participants')]);
        }

        // Ownership check
        if ($event->organizer_id !== $request->user()->id && $request->user()->role !== 'ADMIN') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->update($request->validated());
        return response()->json(['data' => $event]);
    }

    public function destroy(\Illuminate\Http\Request $request, Event $event)
    {
        // Ownership check
        if ($event->organizer_id !== $request->user()->id && $request->user()->role !== 'ADMIN') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();
        return response()->json(null, 204);
    }
}

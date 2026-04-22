<?php

namespace App\Http\Controllers;

use App\Http\Requests\NearbySpotRequest;
use App\Http\Requests\StoreSpotRequest;
use App\Http\Requests\UpdateSpotRequest;
use App\Models\Spot;
use Illuminate\Support\Facades\DB;

class SpotController extends Controller
{
    public function index()
    {
        $spots = Spot::where('status', 'APPROVED')->get();
        return response()->json(['data' => $spots]);
    }

    public function store(StoreSpotRequest $request)
    {
        $validated = $request->validated();
        
        // Handle PostGIS coordinates insert
        $lat = $validated['latitude'];
        $lng = $validated['longitude'];

        $spot = new Spot();
        $spot->name = $validated['name'];
        if (isset($validated['status'])) {
            $spot->status = $validated['status'];
        }
        $spot->coordinates = DB::raw("ST_SetSRID(ST_MakePoint($lng, $lat), 4326)");
        $spot->save();

        return response()->json(['data' => $spot], 201);
    }

    public function show(Spot $spot)
    {
        return response()->json(['data' => $spot]);
    }

    public function update(UpdateSpotRequest $request, Spot $spot)
    {
        $validated = $request->validated();

        if (isset($validated['name'])) {
            $spot->name = $validated['name'];
        }
        if (isset($validated['status'])) {
            $spot->status = $validated['status'];
        }
        if (isset($validated['latitude']) && isset($validated['longitude'])) {
            $lat = $validated['latitude'];
            $lng = $validated['longitude'];
            $spot->coordinates = DB::raw("ST_SetSRID(ST_MakePoint($lng, $lat), 4326)");
        }
        $spot->save();

        return response()->json(['data' => $spot]);
    }

    public function destroy(Spot $spot)
    {
        $spot->delete();
        return response()->json(null, 204);
    }

    public function nearby(NearbySpotRequest $request, \App\Services\MapService $mapService)
    {
        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->input('radius', 5000); // Default 5km

        $spots = $mapService->getNearbySpots($lat, $lng, $radius);

        return response()->json(['data' => $spots]);
    }
}

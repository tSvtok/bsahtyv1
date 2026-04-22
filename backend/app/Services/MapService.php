<?php

namespace App\Services;

use App\Models\Spot;

class MapService
{
    /**
     * Get spots near a specific coordinate within a radius.
     * 
     * @param float $lat
     * @param float $lng
     * @param int $radiusInMeters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNearbySpots(float $lat, float $lng, int $radiusInMeters = 5000)
    {
        // ST_DistanceSphere calculates distance in meters.
        return Spot::whereRaw(
            "ST_DistanceSphere(coordinates, ST_MakePoint(?, ?)) <= ?",
            [$lng, $lat, $radiusInMeters]
        )->where('status', 'APPROVED')->get();
    }

    /**
     * Example placeholder for future external Geocoding (Address to Lat/Lng).
     */
    public function geocodeAddress(string $address)
    {
        // Integration with Google Maps API or OpenStreetMap Nominatim would go here.
        return [
            'lat' => 0.0,
            'lng' => 0.0,
        ];
    }
}

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
        // For now, filter in PHP since coordinates are JSON
        // In production, proper PostGIS queries on a geometry column are better.
        $spots = Spot::where('status', 'APPROVED')->get();

        return $spots->filter(function ($spot) use ($lat, $lng, $radiusInMeters) {
            $coords = $spot->coordinates;
            if (!$coords || !isset($coords['lat']) || !isset($coords['lng'])) {
                return false;
            }

            $distance = $this->haversineDistance($lat, $lng, $coords['lat'], $coords['lng']);
            return $distance <= $radiusInMeters;
        })->values();
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
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

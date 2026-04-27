<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Seeder;

class SpotsSeeder extends Seeder
{
    /**
     * Seed predefined Algiers sports spots
     */
    public function run(): void
    {
        $algiersSpots = [
            ['name' => 'Stade du 5 Juillet', 'lat' => 36.7592, 'lng' => 2.9961, 'type' => 'stadium'],
            ['name' => 'Jardin d\'Essai du Hamma', 'lat' => 36.7483, 'lng' => 3.0647, 'type' => 'park'],
            ['name' => 'Promenade des Sablettes', 'lat' => 36.7424, 'lng' => 3.0858, 'type' => 'track'],
            ['name' => 'Club de Tennis Ben Aknoun', 'lat' => 36.7589, 'lng' => 3.0245, 'type' => 'court'],
            ['name' => 'Gym Hydra Center', 'lat' => 36.7431, 'lng' => 3.0345, 'type' => 'gym'],
            ['name' => 'Piscine Olympique El Biar', 'lat' => 36.7725, 'lng' => 3.0312, 'type' => 'pool'],
        ];

        foreach ($algiersSpots as $spotData) {
            Spot::firstOrCreate(
                ['name' => $spotData['name']],
                [
                    'coordinates' => ['lat' => $spotData['lat'], 'lng' => $spotData['lng']],
                    'status' => 'APPROVED',
                ]
            );
        }

        // Add 20 more random spots in Algiers
        Spot::factory()
            ->count(20)
            ->create();
    }
}

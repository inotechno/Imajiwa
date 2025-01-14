<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Client::create([
            'name' => 'TechnoVerse',
            'contact_person' => '+62 987 654 3210',
        ]);

        Client::create([
            'name' => 'CreativeX Studios',
            'contact_person' => '+62 456 789 0123',
        ]);

        Client::create([
            'name' => 'PixelCraft',
            'contact_person' => '+62 321 654 9876',
        ]);

        Client::create([
            'name' => 'Visionary Labs',
            'contact_person' => '+62 789 012 3456',
        ]);
    }
}

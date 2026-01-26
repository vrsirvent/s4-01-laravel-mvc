<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MusicalStyle;
use Illuminate\Support\Facades\DB;

class MusicalStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('musical_styles')->truncate(); // Clear table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $styles = [
            [
                'name' => 'Blues',
                'description' => 'Blues music features melancholic melodies, expressive vocals, and the 12-bar blues progression.',
            ],
            [
                'name' => 'Jazz',
                'description' => 'Jazz is characterized by swing rhythms, improvisation, and complex harmonies.',
            ],
            [
                'name' => 'Pop',
                'description' => 'Pop music is characterized by catchy melodies, simple chord progressions, and accessible lyrics.',
            ],
            [
                'name' => 'Rock',
                'description' => 'Rock music is characterized by a strong rhythm, amplified electric guitars, and powerful vocals.',
            ],
            [
                'name' => 'Soul',
                'description' => 'Soul music combines elements of gospel, rhythm and blues, and jazz with passionate vocals.',
            ],
            [
                'name' => 'Swing',
                'description' => 'Swing music features a strong rhythm section and emphasis on off-beat accents, perfect for dancing.',
            ],
        ];

        foreach ($styles as $style) {
            MusicalStyle::create($style);
        }

        $this->command->info(' Correct, musical styles inserted.');
    }
}

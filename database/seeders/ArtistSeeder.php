<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('artists')->truncate(); // Clear table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $artists = [
            [
                'name' => 'Blind Melon',
                'description' => 'American rock band from the 1990s, known for alternative rock and psychedelic influences.',
            ],
            [
                'name' => 'Ella Fitzgerald',
                'description' => 'The First Lady of Song. Legendary jazz vocalist known for her pure tone and impeccable diction.',
            ],
            [
                'name' => 'Héroes Del Silencio',
                'description' => 'Spanish rock band from Zaragoza, one of the most influential rock groups in Spanish-language music.',
            ],
            [
                'name' => 'James Brown',
                'description' => 'The Godfather of Soul. Pioneer of funk music and major influence on popular music.',
            ],
            [
                'name' => 'Jane\'s Addiction',
                'description' => 'American rock band formed in Los Angeles, pioneers of alternative rock in the late 1980s.',
            ],
            [
                'name' => 'Kenny Garrett',
                'description' => 'American jazz saxophonist known for his work with Miles Davis and his solo career.',
            ],
            [
                'name' => 'Koko Taylor',
                'description' => 'The Queen of the Blues. Powerful vocalist known for her raw, authentic Chicago blues style.',
            ],
            [
                'name' => 'Otis Redding',
                'description' => 'Soul legend known for his powerful voice and emotional delivery. King of Soul music.',
            ],
            [
                'name' => 'Spandau Ballet',
                'description' => 'British new wave band from the 1980s, known for their sophisticated pop sound.',
            ],
            [
                'name' => 'The Christians',
                'description' => 'British soul and pop group from Liverpool, known for their soulful harmonies.',
            ],
            [
                'name' => 'Wet Wet Wet',
                'description' => 'Scottish pop rock band known for emotional ballads and the hit "Love Is All Around".',
            ],
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }

        $this->command->info('Correct, artists inserted.');

    }
}

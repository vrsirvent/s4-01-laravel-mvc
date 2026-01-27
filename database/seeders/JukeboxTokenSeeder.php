<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JukeboxToken;
use Illuminate\Support\Facades\DB;

class JukeboxTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('jukebox_tokens')->truncate(); // Clear table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tokens = [
            [
                'name' => 'moto_1',
                'song_quantity' => 1,
                'price' => 5.00,
                'stock' => 100,
            ],
            [
                'name' => 'moto_3',
                'song_quantity' => 3,
                'price' => 12.00,
                'stock' => 100,
            ],
            [
                'name' => 'moto_5',
                'song_quantity' => 5,
                'price' => 18.00,
                'stock' => 100,
            ],
            [
                'name' => 'car',
                'song_quantity' => 0,  // 0 = unlimited (all from the artist)
                'price' => 25.00,
                'stock' => 50,
            ],
        ];

        foreach ($tokens as $token) {
            JukeboxToken::create($token);
        }

        $this->command->info('Correct, tokens inserted.');
    }
}

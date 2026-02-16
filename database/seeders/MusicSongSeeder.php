<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MusicSong;
use App\Models\Artist;
use App\Models\MusicalStyle;
use Illuminate\Support\Facades\DB;

class MusicSongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('music_songs')->truncate(); // Clear table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Receive music style IDs
        $blues = MusicalStyle::where('name', 'Blues')->first()->id;
        $jazz = MusicalStyle::where('name', 'Jazz')->first()->id;
        $pop = MusicalStyle::where('name', 'Pop')->first()->id;
        $rock = MusicalStyle::where('name', 'Rock')->first()->id;
        $soul = MusicalStyle::where('name', 'Soul')->first()->id;
        $swing = MusicalStyle::where('name', 'Swing')->first()->id;

        // Receive artist IDs
        $blindMelon = Artist::where('name', 'Blind Melon')->first()->id;
        $ellaFitzgerald = Artist::where('name', 'Ella Fitzgerald')->first()->id;
        $heroesSilencio = Artist::where('name', 'Héroes Del Silencio')->first()->id;
        $jamesBrown = Artist::where('name', 'James Brown')->first()->id;
        $janesAddiction = Artist::where('name', 'Jane\'s Addiction')->first()->id;
        $kennyGarrett = Artist::where('name', 'Kenny Garrett')->first()->id;
        $kokoTaylor = Artist::where('name', 'Koko Taylor')->first()->id;
        $otisRedding = Artist::where('name', 'Otis Redding')->first()->id;
        $spandauBallet = Artist::where('name', 'Spandau Ballet')->first()->id;
        $theChristians = Artist::where('name', 'The Christians')->first()->id;
        $wetWetWet = Artist::where('name', 'Wet Wet Wet')->first()->id;

        // Array Format: [title, duration in seconds, url_file, artist_id, musical_style_id]
        $songs = [
            ['(Sittin\' On) The Dock Of The Bay', 166, 'songs/otis-redding_sittin-on-the-dock-of-the-bay.mp3', $otisRedding, $soul],
            ['Soul Power', 182, 'songs/james-brown_soul-power.mp3', $jamesBrown, $soul],

            ['Delfeayo\'s Dilemma', 341, 'songs/kenny-garrett_delfeayos-dilemma.mp3', $kennyGarrett, $jazz],
            ['Giant Steps', 291, 'songs/kenny-garrett_giant-steps.mp3', $kennyGarrett, $jazz],

            ['Flying Home', 148, 'songs/ella-fitzgerald_flying-home.mp3', $ellaFitzgerald, $swing],

            ['Entre Dos Tierras', 365, 'songs/heroes-del-silencio_entre-dos-tierras.mp3', $heroesSilencio, $rock],
            ['Soak The Sin', 240, 'songs/blind-melon_soak-the-sin.mp3', $blindMelon, $rock],
            ['Had A Dad', 228, 'songs/janes-addiction_had-a-dad.mp3', $janesAddiction, $rock],

            ['Mother Nature', 281, 'songs/koko-taylor_mother-nature.mp3', $kokoTaylor, $blues],
            ['If I Can\'t Be First', 220, 'songs/koko-taylor_if-i-cant-be-first.mp3', $kokoTaylor, $blues],
            ['Hound Dog', 332, 'songs/koko-taylor_hound-dog.mp3', $kokoTaylor, $blues],

            ['Wishing I Was Lucky', 231, 'songs/wet-wet-wet_wishing-i-was-lucky.mp3', $wetWetWet, $pop],
            ['Born Again', 318, 'songs/the-christians_born-again.mp3', $theChristians, $pop],
            ['Only When You Leave', 288, 'songs/spandau-ballet_only-when-you-leave.mp3', $spandauBallet, $pop],
        ];

        // Songs insert
        foreach ($songs as $song) {
            MusicSong::create([
                'title' => $song[0],
                'length' => $song[1],
                'url_file' => $song[2],
                'play_count' => 0,
                'artist_id' => $song[3],
                'musical_style_id' => $song[4],
            ]);
        }

        $this->command->info('Correct, musical songs inserted.');
    }
}

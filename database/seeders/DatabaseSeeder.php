<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        // ]);

        // Startup message
        $this->command->info('🌱 Starting database seeding...');
        $this->command->info('');

        // Execute dependency order
        $this->call([
            MusicalStyleSeeder::class,  
            ArtistSeeder::class,        
            MusicSongSeeder::class,    
            JukeboxTokenSeeder::class, 
        ]);

        // Final message
        $this->command->info('');
        $this->command->info('Correct, database initialized.');
        $this->command->info('Summary:');
        $this->command->info('  - Musical Styles');
        $this->command->info('  - Artists');
        $this->command->info('  - Music Songs');
        $this->command->info('  - Jukebox Tokens');

    }
}


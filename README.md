# City Jukebox

Vintage music simulation built with Laravel

## Description

**City Jukebox** is a web application that simulates a 1950s jukebox, where users can explore music catalogs, manage their favorite songs, and play music using a token system. The project combines a retro aesthetic with neon and animated visual elements.

## Features

### Dual Playback System

- **MOTO Mode**: Individual song playback
  - Tokens for 1, 3, or 5 songs
  - Custom song selection
  - Visual traffic light system for tokens

- **CAR Mode**: Complete artist playback
  - Plays all songs from an artist
  - Animated vehicle visualization

### Functionalities

- **Complete Music Catalog**
  - Song exploration
  - Search by title and artist
  - Artist view with statistics

- **Favorites System**
  - Personal management of favorite songs
  - Add/remove interface (stars in catalog / stars in favorites)

- **Token System**
  - Token purchase with virtual balance
  - 4 token types: MOTO_1, MOTO_3, MOTO_5, CAR
  - User's active token management

- **User Management**
  - Authentication system
  - Personal profile with balance
  - Playback history by artist

### Visual Design

- Retro jukebox-style interface with neon effects
- CSS animations for vehicles and road
- Animated carousel of musical styles
- Responsive design (mobile, tablet, desktop)
- Dark theme with neon color accents

## System Requirements

### Required Software

Before starting, make sure you have these software and verify installation installed:

`php --version`       **PHP 8.2** or higher
`composer --version`  **Composer** 2.x
`node --version`      **Node.js 18.x LTS** or higher
`npm --version`       **NPM** 9.x
`mysql --version`     **MySQL** 8.0

### Optional

- **XAMPP** (Includes Apache and MySQL) - Recommended for beginners
- **Git** - For cloning the repository

## Installation

Follow these steps **in order**. Do not skip any step.

### Step 1: Clone the repository

**Branch:** develop

```bash
git clone https://github.com/vrsirvent/s4-01-laravel-mvc.git
cd s4-01-laravel-mvc
```

### Step 2: Install PHP dependencies

```bash
composer install
```

**If you get a memory error:**

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

### Step 3: Install JavaScript dependencies

```bash
npm install
```

### Step 4: Configure environment variables

**Windows:**

```bash
copy .env.example .env
```

**Mac/Linux:**

```bash
cp .env.example .env
```

**4.2. Edit the `.env` file:**

Open the `.env` file with your text editor and configure these variables:

```env
APP_NAME="City Jukebox"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jukebox_retro_digi
DB_USERNAME=root
DB_PASSWORD=
```

The password is EMPTY (don't write anything in `DB_PASSWORD=`)

### Step 5: Generate application key

```bash
php artisan key:generate
```

This will automatically add the key to your `.env` file.

### Step 6: Create the database

**Before running migrations**, create the database:

#### phpMyAdmin (For XAMPP users)

1. **Start XAMPP:**
   - Open XAMPP Control Panel
   - Click **"Start"** on Apache
   - Click **"Start"** on MySQL
   - Both should show green status

2. **Open phpMyAdmin:**
   - Open your browser
   - Go to: `http://localhost/phpmyadmin`

3. **Create the database:**
   - Click **"New"** in the left panel
   - Database name: `jukebox_retro_digi`
   - Collation: Select `utf8mb4_unicode_ci` from the dropdown
   - Click **"Create"**

4. **Verify:**
   - You should see `jukebox_retro_digi` appear in the left panel

### Step 7: Run migrations

Now that the database exists, create all the tables:

```bash
php artisan migrate
```

"Migrated" messages in green.

**Tables created:**

- `users` - User accounts with custom fields (balance)
- `artists` - Musical artists
- `musical_styles` - Music genres
- `music_songs` - Songs database
- `favorite_songs` - User favorites
- `jukebox_tokens` - Available token types
- `user_tokens` - User-owned tokens
- `cache`, `jobs` - Laravel system tables

### Step 8: Seed the database

If you have **seeders** configured for test data:

```bash
php artisan db:seed
```

### Step 9: Compile frontend assets

**For development:**

```bash
npm run dev
```

**For production:**

```bash
npm run build
```

## Running the Project

### Start the development server

```bash
php artisan serve
```

### Access the application

Open your browser and go to: `http://localhost:8000`

### Stop the server

Press `Ctrl + C` in the terminal where the server is running.

## Verify Installation before using the application

### Check migrations

```bash
php artisan migrate:status
```

### Check database data

```bash
php artisan tinker --execute="echo 'Styles: ' . \App\Models\MusicalStyle::count() . PHP_EOL; echo 'Artists: ' . \App\Models\Artist::count() . PHP_EOL; echo 'Songs: ' . \App\Models\MusicSong::count() . PHP_EOL; echo 'Tokens: ' . \App\Models\JukeboxToken::count() . PHP_EOL;"
```

## Troubleshooting

### ❌ Error: "Unknown database 'jukebox_retro_digi'"

**Cause:** The database doesn't exist in MySQL.
**Solution:**
You must create the database before running migrations.

### ❌ Error: "No application encryption key has been specified"

**Cause:** Missing APP_KEY in `.env` file.
**Solution:**

```bash
php artisan key:generate
```

### ❌ Error: "Access denied for user 'root'@'localhost'"

**Cause:** Incorrect MySQL credentials in `.env`

**Solution:**

1. Open `.env` file
2. Check these lines:

```env
DB_USERNAME=root
DB_PASSWORD=
```

**Test your connection:**

```bash
mysql -u root -p
```

If you can't connect, restart MySQL from XAMPP Control Panel.

### ❌ Blank page with no errors

**Cause:** Debug mode disabled or cache issues.

**Solution:**

1. Enable debug in `.env`:

```env
APP_DEBUG=true
```

2. Clear all cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### ❌ Changes in CSS/JS not showing

**Cause:** Browser cache or assets not recompiled.

**Solution:**

1. Recompile assets:

```bash
npm run build
```

2. Clear Laravel cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Emergency Commands

If nothing works, try these:

```bash
# Clean everything
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
# Reinstall dependencies
composer install
npm install
# Recompile assets
npm run build
# Check configuration
php artisan config:show
php artisan migrate:status
```

## Configuration

### Initial Credits Configuration

Users receive **€ 1000.00** as initial balance by default. This is configured in the migration:

```php
// database/migrations/*_add_custom_fields_to_users_table.php
$table->decimal('Money', 10, 2)->default(1000.00);
```

To change the initial balance, modify this value and run:
Warning: This will delete all existing data.

```bash
php artisan migrate:fresh --seed
```

### Token Configuration

Tokens are configured through seeders: `database/seeders/JukeboxTokenSeeder.php`

## Functionalities

### Main Dashboard (`/dashboard`)

This is the application's hub, where users interact with the jukebox.

**Elements included:**

1. **Visual Player** (`_player.blade.php`)
   - Vehicle animations (motorcycle/car)
   - Traffic light system for quantity selection
   - Playback controls (play, pause, next)
   - Balance and status indicators

2. **Catalog** (`_catalog.blade.php`)
   - Dynamic view according to selected mode
   - MOTO Mode: song list with multiple selection
   - CAR Mode: artist list
   - Integrated favorite buttons (add)

3. **Favorites** (`_favorites.blade.php`)
   - Personal list of favorite songs
   - Quick favorites management (remove)

4. **Search** (`_search.blade.php`)
   - Real-time search
   - Filter by title or artist
   - Clear search button

5. **My available tokens** (`_tickets.blade.php`)
   - Active token visualization
   - Real-time counter
   - Color indicators by type

6. **Buy Tokens** (`_buy-tokens.blade.php`)
   - Token store
   - Direct purchase with credits
   - Prices and descriptions

### Other Pages

#### Song Catalog (`/songs`)

- Complete listing of all songs
- Filter by musical style
- Real-time search
- Detailed information (artist, genre)

#### Artist Catalog (`/artist`)

- Artist exploration
- Filter by associated musical styles
- Real-time search
- Statistics (number of songs, plays)
- Artist descriptions

#### Musical Styles (`/musical-style`)

- View of all available genres
- Statistics by style (songs, artists)
- Descriptions of each genre
- Distinctive colors by style

### Breeze Authentication System

- User registration
- Login/Logout
- Password recovery
- Profile management
- Email verification

## Project Structure

city-jukebox project/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/                      # Authentication created by Breeze
│   │       ├── JukeboxController.php      # Jukebox logic
│   │       ├── PlayerController.php       # Music playback
│   │       ├── FavoriteController.php     # Favorites management
│   │       ├── SongController.php         # Song catalog
│   │       ├── ArtistController.php       # Artist catalog
│   │       └── MusicalStyleController.php # Musical styles
│   │
│   └── Models/
│       ├── User.php
│       ├── Artist.php
│       ├── MusicalStyle.php
│       ├── MusicSong.php
│       ├── FavoriteSong.php
│       ├── JukeboxToken.php
│       └── UserToken.php
│
├── database/
│   └── migrations/
│       ├── *_create_artists_table.php
│       ├── *_create_musical_styles_table.php
│       ├── *_create_music_songs_table.php
│       ├── *_create_favorite_songs_table.php
│       ├── *_create_jukebox_tokens_table.php
│       ├── *_create_user_tokens_table.php
│       ├── *_add_custom_fields_to_users_table.php
│       └── ... (other migrations)
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php           # Landing page
│   │   ├── dashboard.blade.php         # Main dashboard
│   │   ├── song.blade.php              # Song catalog
│   │   ├── artist.blade.php            # Artist catalog
│   │   ├── musical-style.blade.php     # Musical styles
│   │   │
│   │   ├── components/
│   │   │   ├── responsive-nav-link.blade.php     # Responsive navigation
│   │   │   ├── category-carousel.blade.php       # Carousel text light
│   │   │   └── success-error-message.blade.php   # Error messages
│   │   │
│   │   ├── partials/                     # Belong to main dashboard
│   │   │   ├── _player.blade.php          # Visual player
│   │   │   ├── _catalog.blade.php         # Dynamic catalog
│   │   │   ├── _favorites.blade.php       # Favorites list
│   │   │   ├── _search.blade.php          # Search bar
│   │   │   ├── _tickets.blade.php         # User tickets
│   │   │   └── _buy-tokens.blade.php      # Token store
│   │   │
│   │   ├── auth/                         # Created by Breeze
│   │   ├── errors/
│   │   │   └── 404.blade.php             # 404 Error
│   │   └── layouts/                      # Created by Breeze
│   │       ├── app.blade.php             # Main for authenticated users
│   │       ├── guest.blade.php           # Unauthenticated visitors
│   │       └── navigation.blade.php      # Reusable navigation (header)
│   │
│   ├── css/
│   │   └── app.css                       # Main styles
│   └── js/
│       └── app.js                        # Main JavaScript
│
├── routes/
│   ├── web.php                           # Web routes
│   └── auth.php                          # Authentication routes
│
├── public/
│   └── audio/
│       └── songs/                        # MP3 files
│
├── .env.example                          # Environment variables template
├── .env                                  # Your configuration (DO NOT commit to Git)
├── composer.json                         # PHP dependencies
├── package.json                          # Node.js dependencies
└── README.md                             # This file

## Routes

### Public Routes

```php
GET  '/'                        # Welcome page
```

### Protected Routes (Require Authentication)

```php
# Dashboard and Jukebox
GET  '/dashboard'               # Main dashboard
POST '/jukebox/purchase-token'  # Purchase token
POST '/player/consume-token'    # Consume token to play

# Favorites
POST '/favorites/toggle'        # Add/remove favorite

# Catalogs
GET  '/songs'                   # Song catalog
GET  '/artist'                  # Artist catalog
GET  '/musical-style'           # Musical styles

# User Profile
GET  '/profile'                 # View profile
PATCH '/profile'                # Update profile
DELETE '/profile'               # Delete account
```

### Authentication Routes (Breeze)

```php
# Registration
GET  '/register'
POST '/register'

# Login
GET  '/login'
POST '/login'
POST '/logout'

# Password Recovery
GET  '/forgot-password'
POST '/forgot-password'
GET  '/reset-password/{token}'
POST '/reset-password'

# Email Verification
GET  '/verify-email'
POST '/email/verification-notification'
GET  '/email/verify/{id}/{hash}'
```

## Technologies Used

### Backend

- **Framework**: Laravel 11.x
- **Authentication**: Laravel Breeze
- **Database**: Eloquent ORM (MySQL)
- **Validation**: Form Requests
- **Migrations**: Schema Builder

### Frontend

- **CSS Framework**: Tailwind CSS 3.x
- **Component Libraries**: DaisyUI 5.x, Flowbite 4.x
- **JavaScript Framework**: Alpine.js 3.x
- **Template Engine**: Blade Templates
- **Build Tool**: Vite 7.x
- **Icons**: Unicode Emojis ([Emojipedia](https://emojipedia.org))
- **Animations**: CSS Animations + Transitions

### Alpine.js Components

```javascript
// Application state
x-data="jukeboxApp()"

// Main functions:
- init()                  // Initialization
- selectMode()            // Select moto/car mode
- selectQuantity()        // Select song quantity
- toggleSongSelection()   // Select/deselect song
- selectArtist()          // Select artist
- addFavorite()           // Add to favorites
- removeFavorite()        // Remove from favorites
- consumeToken()          // Consume token and play
```

### Authentication Middleware

Protected routes use:

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // protected routes
});
```

### Data Validation

Controllers validate input data before processing to ensure data integrity.

## Audio

### File used

- **Title:** Backseat Bop - 1950s Style Rock And Roll
- **Artist:** kaazoom
- **Source:** [Pixabay Music](https://pixabay.com/music/)
- **License:** [Pixabay Content License](https://pixabay.com/service/license-summary/)
- **Usage:** Free for commercial and non-commercial purposes
- **Attribution:** Not required

All MP3 files in `public/audio/songs/` are copies of this single file, renamed to correspond with the songs in the database.

### Important clarification

The MP3 files are **NOT the original recordings** of Elvis Presley, Chuck Berry, Ray Charles, etc. They are copies of a single instrumental sample file downloaded from Pixabay Music.

**Purpose:** To demonstrate audio playback functionality in an educational context, NOT commercial music distribution.

**Legal compliance:**

- Artist and song names in the database are information public domain
- Audio files are royalty-free music from Pixabay
- No copyrighted recordings are included

## License

This project is developed for educational purposes as part of the IT Academy Full Stack PHP program.

## Project Developed By

**Vicenç Sirvent**  
IT Academy - Barcelona Activa  
Sprint 4 - Full Stack PHP 2025-2026

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

- **PHP**: 8.2 or higher
- **Composer**: 2.x
- **Node.js**: 18.x or higher
- **NPM**: 9.x or higher
- **Database**: MySQL 8.0+
- **Web Server**: Apache

## Installation

Follow these steps to install and run the project in your local environment.

### 1. Clone the repository (develop)

```bash
git clone https://github.com/vrsirvent/s4-01-laravel-mvc.git
cd s4-01-laravel-mvc
```

### 2. Install dependencies

- PHP dependencies

```bash
composer install
```

- Node.js dependencies

```bash
npm install
```

### 3. Configure environment variables

```bash
cp .env.example .env
```

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=city_jukebox
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Create database and run migrations

Make sure the database exists on your MySQL server, then:

```bash
php artisan migrate
```

If you have **seeders** configured for test data:

```bash
php artisan db:seed
```

### 6. Compile frontend assets

```bash
# Development
npm run dev

# Production
npm run build
```

## Running the Project

- Start the Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Database (MySQL)

In the application, the `.env.example` file is configured for **MySQL**.

## Configuration

### Initial Credits Configuration

Users receive **€1000.00** as initial balance by default. This is configured in the migration:

```php
// database/migrations/*_add_custom_fields_to_users_table.php
$table->decimal('Money', 10, 2)->default(1000.00);
```

### Token Configuration

Jukebox tokens must be created manually or through seeders.

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

```
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
│   │   │
│   │   ├── errors/
│   │   │   └── 404.blade.php             # 404 Error
│   │   │
│   │   └── layouts/                      # Created by Breeze
│   │       ├── app.blade.php             # Main for authenticated users
│   │       ├── guest.blade.php           # Unauthenticated visitors
│   │       └── navigation.blade.php      # Reusable navigation (header)
│   │
│   ├── css/
│   │   └── app.css                       # Main styles
│   │
│   └── js/
│       └── app.js                        # Main JavaScript
│
├── routes/
│   ├── web.php                           # Web routes
│   └── auth.php                          # Authentication routes
│
├── .env.example                          # Environment variables template
├── composer.json                         # PHP dependencies
├── package.json                          # Node.js dependencies
└── README.md                             # This file
```

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
- **Authentication**: Breeze
- **Database**: Eloquent ORM
- **Validation**: Form Requests
- **Migrations**: Schema Builder

### Frontend

- **CSS Framework**: Tailwind CSS 3.x (plus component libraries DaisyUI 5.x and Flowbite @4.x)
- **JavaScript Framework**: Alpine.js 3.x
- **Components**: Blade Templates
- **Build Tool**: Vite
- **Icons**: Unicode Emojis from URL <https://emojipedia.org>
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

Controllers validate input data before processing.

## Project Developed By

Vicenç Sirvent - IT Academy - Barcelona Activa
Sprint 4 - Full Stack PHP 2025-2026



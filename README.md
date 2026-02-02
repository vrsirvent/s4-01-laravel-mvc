# City Jukebox

Simulación musical vintage construida con Laravel

## Descripción

**City Jukebox** es una aplicación web que simula un jukebox de los años 50, donde los usuarios pueden explorar catálogos musicales, gestionar sus canciones favoritas y reproducir música utilizando un sistema de tokens. El proyecto combina una estética retro con neón y elementos visuales animados.

## Características

### Sistema doble de Reproducción

- **Modo MOTO**: Reproducción de canciones individuales
  - Tokens de 1, 3 o 5 canciones
  - Selección personalizada de temas
  - Sistema de luces en un semáforo visual para los tokens

- **Modo CAR**: Reproducción de artistas completos
  - Reproduce todas las canciones de un artista
  - Visualización animada del vehículo

### Funcionalidades

- **Catálogo Musical Completo**
  - Exploración de canciones
  - Búsqueda por título y artista
  - Vista de artistas con estadísticas

- **Sistema de Favoritos**
  - Gestión personal de canciones favoritas
  - Interfaz de añadir (estrellas catálogo) / eliminar (estrellas favoritos)

- **Sistema de Tokens**
  - Compra de tokens con saldo virtuales
  - 4 tipos de tokens: MOTO_1, MOTO_3, MOTO_5, CAR
  - Gestión de tokens activos del usuario

- **Gestión de Usuarios**
  - Sistema de autenticación
  - Perfil personal con saldo
  - Historial de reproducción por artista

### Diseño Visual

- Interfaz estilo jukebox retro con efectos neón
- Animaciones CSS para vehículos y carretera
- Carrusel animado de estilos musicales
- Diseño responsive (móvil, tablet, desktop)
- Tema oscuro con acentos de colores neón

## Requisitos del Sistema

- **PHP**: 8.2 o superior
- **Composer**: 2.x
- **Node.js**: 18.x o superior
- **NPM**: 9.x o superior
- **Base de datos**: MySQL 8.0+
- **Servidor web**: Apache

## Instalación

Sigue estos pasos para instalar y ejecutar el proyecto en tu entorno local.

### 1. Clonar el repositorio (develop)

```bash
git clone https://github.com/vrsirvent/s4-01-laravel-mvc.git
cd s4-01-laravel-mvc
```

### 2. Instalar dependencias

- Dependencias de PHP

```bash
composer install
```

- Dependencias de Node.js

```bash
npm install
```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
```

Edita el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=city_jukebox
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Crear la base de datos y ejecutar migraciones

Asegúrate de que la base de datos existe en tu servidor MySQL, luego:

```bash
php artisan migrate
```

Si tienes **seeders** configurados para datos de prueba:

```bash
php artisan db:seed
```

### 6. Compilar assets del frontend

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

## Ejecutar el proyecto

- Iniciar el Servidor

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## Base de Datos (MySQL)

En la aplicación el fichero `.env.example` está configurado para **MySQL**.

## Configuración

### Configuración de Créditos Iniciales

Los usuarios reciben **1000.00 €** como saldo inicial por defecto. Esto se configura en la migración:

```php
// database/migrations/*_add_custom_fields_to_users_table.php
$table->decimal('Money', 10, 2)->default(1000.00);
```

### Configuración de Tokens

Los tokens del jukebox deben ser creados manualmente o mediante seeders.

## Funcionalidades

### Dashboard Principal (`/dashboard`)

Es el centro de la aplicación, donde los usuarios interactúan con el jukebox.

**Elementos que lo incluyen:**

1. **Player Visual** (`_player.blade.php`)

   - Animaciones de vehículos (moto/carro)
   - Sistema de semáforo para selección de cantidad
   - Controles de reproducción (play, pause, next)
   - Indicadores de saldo y estado

2. **Catálogo** (`_catalog.blade.php`)

   - Vista dinámica según modo seleccionado
   - Modo MOTO: lista de canciones con selección múltiple
   - Modo CAR: lista de artistas
   - Botones de favoritos integrados (añadir)

3. **Favoritos** (`_favorites.blade.php`)

   - Lista personal de canciones favoritas
   - Gestión rápida de favoritos (remove)

4. **Búsqueda** (`_search.blade.php`)

   - Búsqueda en tiempo real
   - Filtrado por título o artista
   - Botón de limpiar búsqueda

5. **Mis Tickets** (`_tickets.blade.php`)

   - Visualización de tokens activos
   - Contador en tiempo real
   - Indicadores de color por tipo

6. **Comprar Tokens** (`_buy-tokens.blade.php`)

   - Tienda de tokens
   - Compra directa con créditos
   - Precios y descripciones

### Otras páginas

#### Catálogo de Canciones (`/songs`)

- Listado completo de todas las canciones
- Filtrado por estilo musical
- Búsqueda en tiempo real
- Información detallada (artista, género)

#### Catálogo de Artistas (`/artist`)

- Exploración de artistas
- Filtrado por estilos musicales asociados
- Búsqueda en tiempo real
- Estadísticas (número de canciones, reproducciones)
- Descripciones de artistas

#### Estilos Musicales (`/musical-style`)

- Vista de todos los géneros disponibles
- Estadísticas por estilo (canciones, artistas)
- Descripciones de cada género
- Color distintivos por estilo

### Sistema de Autenticación Breeze

- Registro de usuarios
- Login/Logout
- Recuperación de contraseña
- Gestión de perfil
- Email verification

## Estructura del proyecto

Proyecto city-jukebox/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/                      # Autenticación creados por Breeze
│   │       ├── JukeboxController.php      # Lógica del jukebox
│   │       ├── PlayerController.php       # Reproducción de música
│   │       ├── FavoriteController.php     # Gestión de favoritos
│   │       ├── SongController.php         # Catálogo de canciones
│   │       ├── ArtistController.php       # Catálogo de artistas
│   │       └── MusicalStyleController.php # Estilos musicales
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
│       ├──*_create_musical_styles_table.php
│       ├── *_create_music_songs_table.php
│       ├──*_create_favorite_songs_table.php
│       ├── *_create_jukebox_tokens_table.php
│       ├──*_create_user_tokens_table.php
│       ├── *_add_custom_fields_to_users_table.php
│       └── ... (resto de migraciones)
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php              # Landing page
│   │   ├── dashboard.blade.php            # Dashboard principal
│   │   ├── song.blade.php                 # Catálogo de canciones
│   │   ├── artist.blade.php               # Catálogo de artistas
│   │   ├── musical-style.blade.php        # Estilos musicales
│   │   │
│   │   ├── partials/                      # Pertenecen al dashboard principal
│   │   │   ├──_player.blade.php          # Reproductor visual
│   │   │   ├──_catalog.blade.php         # Catálogo dinámico
│   │   │   ├──_favorites.blade.php       # Lista de favoritos
│   │   │   ├──_search.blade.php          # Barra de búsqueda
│   │   │   ├──_tickets.blade.php         # Tickets del usuario
│   │   │   └──_buy-tokens.blade.php      # Tienda de tokens
│   │   │
│   │   ├── auth/                          # Creados por Breeze
│   │   │
│   │   ├── errors/
│   │   │   ├── 404.blade.php              # Error 404
│   │   │
│   │   └── layouts/                       # Creados por Breeze
│   │       ├── app.blade.php              # Principal para usuarios autenticados
│   │       ├── guest.blade.php            # Visitantes no autenticados
│   │       ├── navigation.blade.php       # Navegación reutilizable (cabecera)
│   │
│   ├── css/
│   │   └── app.css                        # Estilos principales
│   │
│   └── js/
│       └── app.js                         # JavaScript principal
│
├── routes/
│   ├── web.php                            # Rutas web
│   └── auth.php                           # Rutas de autenticación
│
├── .env.example                           # Plantilla de variables de entorno
├── composer.json                          # Dependencias PHP
├── package.json                           # Dependencias Node.js
└── README.md                              # Este archivo

## Rutas

### Rutas Públicas

```php
GET  '/'                        # Página de bienvenida
```

### Rutas Protegidas (Requieren Autenticación)

```php
# Dashboard y Jukebox
GET  '/dashboard'               # Dashboard principal
POST '/jukebox/purchase-token'  # Comprar token
POST '/player/consume-token'    # Consumir token para reproducir

# Favoritos
POST '/favorites/toggle'        # Añadir/eliminar favorito

# Catálogos
GET  '/songs'                   # Catálogo de canciones
GET  '/artist'                  # Catálogo de artistas
GET  '/musical-style'           # Estilos musicales

# Perfil de Usuario
GET  '/profile'                 # Ver perfil
PATCH '/profile'                # Actualizar perfil
DELETE '/profile'               # Eliminar cuenta
```

### Rutas de Autenticación (Breeze)

```php
# Registro
GET  '/register'
POST '/register'

# Login
GET  '/login'
POST '/login'
POST '/logout'

# Recuperación de Contraseña
GET  '/forgot-password'
POST '/forgot-password'
GET  '/reset-password/{token}'
POST '/reset-password'

# Verificación de Email
GET  '/verify-email'
POST '/email/verification-notification'
GET  '/email/verify/{id}/{hash}'
```

## Tecnologías Utilizadas

### Backend

- **Framework**: Laravel 11.x
- **Autenticación**: Breeze
- **Base de Datos**: Eloquent ORM
- **Validación**: Form Requests
- **Migraciones**: Schema Builder

### Frontend

- **CSS Framework**: Tailwind CSS 3.x, (más librerías de componentes DaisyUI 5.x y Flowbite @4.x)
- **JavaScript Framework**: Alpine.js 3.x
- **Componentes**: Blade Templates
- **Build Tool**: Vite
- **Iconos**: Emojis Unicode de la URL <https://emojipedia.org>
- **Animaciones**: CSS Animations + Transitions

### Componentes Alpine.js

```javascript
// Estado de la aplicación
x-data="jukeboxApp()"

// Funciones principales:
- init()                  // Inicialización
- selectMode()            // Seleccionar modo moto/car
- selectQuantity()        // Seleccionar cantidad de canciones
- toggleSongSelection()   // Seleccionar/deseleccionar canción
- selectArtist()          // Seleccionar artista
- addFavorite()           // Añadir a favoritos
- removeFavorite()        // Quitar de favoritos
- consumeToken()          // Consumir token y reproduc
```

### Middleware de Autenticación

Las rutas protegidas usan:

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // rutas protegidas
});
```

### Validación de Datos

Los controladores validan datos de entrada antes de procesarlos.

## Proyecto desarrollado por

Vicenç Sirvent - IT Academy - Barcelona Activa
Sprint 4 - Full Stack PHP 2025-2026



# 👀 Vista Previa del Proyecto PUNTO TATTO

## 📊 Estructura Visual del Proyecto

### 🌐 Frontend (Nuxt 3)

```
┌─────────────────────────────────────────────────────────┐
│                    PÁGINAS PÚBLICAS                      │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  🏠 Landing Page (/)                                    │
│     ├─ Hero Section con título                          │
│     ├─ Artistas Destacados (8 artistas)                 │
│     └─ Call to Action                                   │
│                                                          │
│  👥 Listado de Artistas (/artists)                      │
│     ├─ Filtros: Búsqueda, Estilo, Ciudad               │
│     ├─ Grid de tarjetas de artistas                     │
│     ├─ Información: Foto, Nombre, Rating, Estilos      │
│     └─ Paginación                                       │
│                                                          │
│  🎨 Perfil Público Artista (/artists/[id])             │
│     ├─ Header: Foto, Nombre, Rating, Estilos           │
│     ├─ Botones: Contactar, Agregar a Favoritos         │
│     ├─ Sección "Sobre el artista"                      │
│     ├─ Galería de trabajos (Grid 3 columnas)           │
│     ├─ Reseñas con ratings                             │
│     └─ Sidebar: Precio, Horarios, Portfolio            │
│                                                          │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│              PANEL ARTISTA (/artista/*)                 │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  📊 Dashboard                                           │
│     ├─ Stats: Vistas, Contactos, Rating, Ranking       │
│     ├─ Mensajes sin leer                               │
│     └─ Estado de membresía                             │
│                                                          │
│  👤 Perfil                                              │
│  🖼️  Galería                                            │
│  💳 Membresía                                           │
│  💬 Mensajes                                            │
│  📈 Estadísticas                                        │
│                                                          │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│              PANEL CLIENTE (/cliente/*)                 │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  📊 Dashboard                                           │
│     ├─ Stats: Favoritos, Reseñas, Mensajes            │
│     └─ Acceso rápido a búsqueda                        │
│                                                          │
│  ❤️  Favoritos                                          │
│  💬 Mensajes                                            │
│                                                          │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│              PANEL ADMIN (/admin/*)                     │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  📊 Dashboard                                           │
│     ├─ Stats: Artistas, Clientes, Pagos, Reseñas      │
│     └─ Métricas generales                              │
│                                                          │
│  👥 Gestión Artistas                                    │
│  👤 Gestión Clientes                                    │
│  💰 Pagos                                               │
│  📢 Publicidad                                          │
│  🏆 Ranking                                             │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### 🔌 Backend API (Laravel)

```
┌─────────────────────────────────────────────────────────┐
│                    ENDPOINTS API                        │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  🌍 PÚBLICO                                             │
│     GET  /api/public/artists          Lista artistas    │
│     GET  /api/public/artists/{id}     Perfil artista    │
│     GET  /api/public/styles           Estilos           │
│                                                          │
│  🔐 AUTENTICACIÓN                                       │
│     POST /api/auth/register           Registro          │
│     POST /api/auth/login              Login             │
│     POST /api/auth/logout             Logout            │
│     GET  /api/auth/user               Usuario actual    │
│                                                          │
│  🎨 ARTISTA (Protegido)                                 │
│     GET  /api/artist/dashboard        Dashboard         │
│     GET  /api/artist/profile          Perfil            │
│     PUT  /api/artist/profile          Actualizar        │
│     GET  /api/artist/gallery          Galería           │
│     POST /api/artist/gallery          Nueva foto        │
│     GET  /api/artist/messages         Mensajes          │
│     GET  /api/artist/statistics       Estadísticas      │
│                                                          │
│  👤 CLIENTE (Protegido)                                 │
│     GET  /api/client/dashboard        Dashboard         │
│     GET  /api/client/favorites        Favoritos         │
│     POST /api/client/favorites/{id}   Agregar favorito  │
│     GET  /api/client/messages         Mensajes          │
│     POST /api/client/reviews          Nueva reseña      │
│                                                          │
│  👑 ADMIN (Protegido)                                   │
│     GET  /api/admin/dashboard         Dashboard         │
│     GET  /api/admin/artists           Lista artistas    │
│     PUT  /api/admin/artists/{id}/verify   Verificar     │
│     GET  /api/admin/payments          Pagos             │
│     GET  /api/admin/advertisements    Publicidad        │
│     POST /api/admin/ranking/recalculate  Recalcular     │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### 🗄️ Base de Datos

```
┌─────────────────────────────────────────────────────────┐
│                   ESQUEMA DE BD                         │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  👤 users                                               │
│     ├─ id, name, email, password, role                 │
│     ├─ phone, photo, is_active                         │
│     └─ timestamps                                       │
│                                                          │
│  🎨 artists                                             │
│     ├─ user_id (FK)                                    │
│     ├─ studio_name, bio, styles (JSON)                 │
│     ├─ location, latitude, longitude                   │
│     ├─ price_per_hour, working_hours (JSON)            │
│     ├─ rating_average, reviews_count                   │
│     ├─ ranking_score, ranking_position                 │
│     └─ timestamps                                       │
│                                                          │
│  👥 clients                                             │
│     ├─ user_id (FK)                                    │
│     └─ preferred_contact_method                        │
│                                                          │
│  💳 memberships                                         │
│     ├─ name, slug, price                               │
│     ├─ max_photos, featured                            │
│     ├─ priority_ranking, ranking_bonus                 │
│     └─ features (JSON)                                 │
│                                                          │
│  📸 galleries                                           │
│     ├─ artist_id (FK)                                  │
│     ├─ image_url, title, description                   │
│     ├─ style, body_part                                │
│     └─ views_count, likes_count                        │
│                                                          │
│  ⭐ reviews                                             │
│     ├─ artist_id (FK), client_id (FK)                  │
│     ├─ rating (1-5), comment                           │
│     ├─ photos (JSON), is_approved                      │
│     └─ timestamps                                       │
│                                                          │
│  💬 messages                                            │
│     ├─ sender_id (FK), receiver_id (FK)                │
│     ├─ message, is_read, read_at                       │
│     └─ timestamps                                       │
│                                                          │
│  💰 payments                                            │
│     ├─ artist_id, membership_id                        │
│     ├─ openpay_transaction_id                          │
│     ├─ amount, status, type                            │
│     └─ timestamps                                       │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

## 🎨 Diseño Visual

### Colores Principales
- **Primario**: Rojo (#ef4444) - Para CTAs y elementos importantes
- **Secundario**: Grises - Para texto y fondos
- **Acento**: Amarillo - Para ratings y estrellas

### Componentes UI
- **Cards**: Fondos blancos con sombras suaves
- **Botones**: Bordes redondeados, estados hover
- **Formularios**: Inputs con focus states
- **Navegación**: Sidebar fijo en paneles

## 🚀 Para Ver el Proyecto en Acción

### Opción 1: Instalación Completa (Recomendada)

1. **Instalar dependencias del sistema:**
   ```bash
   ./install.sh
   ```

2. **Configurar backend:**
   ```bash
   cd backend
   composer install
   cp .env.example .env
   # Editar .env con credenciales de BD
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

3. **Configurar frontend:**
   ```bash
   cd frontend
   npm install
   ```

4. **Iniciar servidores:**
   ```bash
   ./start-dev.sh
   ```

### Opción 2: Visualización Manual

**Backend:**
```bash
cd backend
composer install
php artisan serve
# Backend en http://localhost:8000
```

**Frontend:**
```bash
cd frontend
npm install
npm run dev
# Frontend en http://localhost:3000
```

## 📱 URLs del Proyecto

Una vez iniciado:

- **Frontend Principal**: http://localhost:3000
- **Backend API**: http://localhost:8000/api
- **API Docs**: http://localhost:8000/api/public/artists (ejemplo)

## 🔑 Credenciales de Prueba

**Admin:**
- Email: `admin@puntotatto.com`
- Password: `admin123`

## 📸 Capturas de Pantalla Esperadas

### Landing Page
- Hero section con gradiente rojo
- Grid de 8 artistas destacados
- Cards con foto, nombre, rating

### Listado de Artistas
- Filtros en la parte superior
- Grid responsive de artistas
- Paginación en la parte inferior

### Panel Artista
- Sidebar izquierdo con navegación
- Dashboard con estadísticas en cards
- Métricas visuales (vistas, contactos, rating)

### Panel Admin
- Vista general con métricas
- Tablas de gestión
- Filtros y búsquedas

## ⚠️ Nota Importante

Para ejecutar el proyecto necesitas:
- PHP 8.2+
- Composer
- Node.js 18+
- PostgreSQL
- OpenPay (para pagos, opcional para desarrollo)

Si no tienes estas herramientas instaladas, ejecuta:
```bash
./install.sh
```

Esto instalará automáticamente las dependencias necesarias (requiere Homebrew en macOS).


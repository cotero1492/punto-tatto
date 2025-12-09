# 🎨 PUNTO TATTO - Plataforma de Membresías para Artistas de Tatuaje

Plataforma web completa para gestionar membresías de estudios de tatuaje y artistas, donde los artistas pueden promocionarse y los clientes pueden encontrarlos y contactarlos.

## 🚀 Características

### Panel Artista
- Dashboard con estadísticas en tiempo real
- Perfil completo con información del estudio
- Galería de trabajos (con límites según membresía)
- Gestión de membresías y pagos
- Sistema de mensajería interna
- Estadísticas avanzadas

### Panel Cliente
- Búsqueda y filtrado avanzado de artistas
- Ver perfiles completos y galerías
- Sistema de favoritos
- Mensajería interna con artistas
- Sistema de reseñas y calificaciones

### Panel Administrador
- Dashboard con métricas generales
- Gestión completa de usuarios (artistas y clientes)
- Gestión de membresías y planes
- Monitoreo de pagos
- Gestión de publicidad y banners
- Sistema de ranking configurable
- Moderación de contenido y reseñas
- Reportes y analíticas

## 🛠️ Stack Tecnológico

### Backend
- **Laravel 11+** - Framework PHP
- **PostgreSQL** - Base de datos
- **Laravel Sanctum** - Autenticación API
- **OpenPay SDK** - Procesamiento de pagos

### Frontend
- **Nuxt 3** - Framework Vue.js
- **TypeScript** - Tipado estático
- **Tailwind CSS** - Estilos
- **Pinia** - Gestión de estado
- **VueUse** - Utilidades composables

## 📋 Requisitos Previos

- PHP 8.2 o superior
- Composer
- PostgreSQL
- Node.js 18+ y npm/yarn
- OpenPay cuenta (para pagos)

## 🔧 Instalación

### Backend (Laravel)

1. Navega al directorio backend:
```bash
cd backend
```

2. Instala las dependencias:
```bash
composer install
```

3. Copia el archivo de entorno:
```bash
cp .env.example .env
```

4. Genera la clave de aplicación:
```bash
php artisan key:generate
```

5. Configura el archivo `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=punto_tatto
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

6. Configura OpenPay en `.env`:
```env
OPENPAY_MERCHANT_ID=tu_merchant_id
OPENPAY_PRIVATE_KEY=tu_private_key
OPENPAY_PUBLIC_KEY=tu_public_key
OPENPAY_PRODUCTION=false
```

7. Ejecuta las migraciones:
```bash
php artisan migrate
```

8. Ejecuta los seeders:
```bash
php artisan db:seed
```

9. Inicia el servidor de desarrollo:
```bash
php artisan serve
```

El backend estará disponible en `http://localhost:8000`

### Frontend (Nuxt 3)

1. Navega al directorio frontend:
```bash
cd frontend
```

2. Instala las dependencias:
```bash
npm install
# o
yarn install
```

3. Configura la URL del API en `.env` (opcional, usa el valor por defecto):
```env
API_BASE_URL=http://localhost:8000/api
```

4. Inicia el servidor de desarrollo:
```bash
npm run dev
# o
yarn dev
```

El frontend estará disponible en `http://localhost:3000`

## 🔐 Usuario Administrador por Defecto

Después de ejecutar los seeders, puedes iniciar sesión con:

- **Email**: admin@puntotatto.com
- **Password**: admin123

**⚠️ IMPORTANTE**: Cambia esta contraseña en producción.

## 📁 Estructura del Proyecto

```
PUNTO TATTO 2026/
├── backend/                    # Laravel API
│   ├── app/
│   │   ├── Http/Controllers/   # Controladores API
│   │   ├── Models/             # Modelos Eloquent
│   │   ├── Services/           # Servicios (OpenPay, Ranking)
│   │   └── Policies/           # Policies de autorización
│   ├── database/
│   │   ├── migrations/         # Migraciones de BD
│   │   └── seeders/            # Seeders
│   └── routes/
│       └── api.php             # Rutas API
│
└── frontend/                   # Nuxt 3
    ├── pages/                  # Páginas/Views
    ├── components/             # Componentes Vue
    ├── layouts/                # Layouts
    ├── stores/                 # Stores Pinia
    ├── composables/            # Composables
    └── utils/                  # Utilidades
```

## 🔌 API Endpoints Principales

### Público
- `GET /api/public/artists` - Listar artistas
- `GET /api/public/artists/{id}` - Perfil de artista
- `GET /api/public/styles` - Lista de estilos

### Autenticación
- `POST /api/auth/register` - Registro
- `POST /api/auth/login` - Login
- `POST /api/auth/logout` - Logout
- `GET /api/auth/user` - Usuario actual

### Artista
- `GET /api/artist/dashboard` - Dashboard
- `GET /api/artist/profile` - Perfil
- `PUT /api/artist/profile` - Actualizar perfil
- `GET /api/artist/gallery` - Galería
- `POST /api/artist/gallery` - Agregar foto

### Cliente
- `GET /api/client/dashboard` - Dashboard
- `GET /api/client/favorites` - Favoritos
- `POST /api/client/favorites/{id}` - Agregar favorito

### Admin
- `GET /api/admin/dashboard` - Dashboard
- `GET /api/admin/artists` - Listar artistas
- `PUT /api/admin/artists/{id}/verify` - Verificar artista

## 📝 Planes de Membresía

El sistema incluye 3 planes predefinidos:

1. **Básico** ($299 MXN/mes)
   - 10 fotos máximo
   - Perfil básico

2. **Premium** ($599 MXN/mes)
   - Fotos ilimitadas
   - Perfil destacado
   - Prioridad en ranking
   - Estadísticas avanzadas

3. **VIP** ($999 MXN/mes)
   - Todo lo de Premium
   - Bonus extra de ranking
   - Soporte prioritario

## 🚀 Próximos Pasos

### Para Desarrollo
1. Configurar OpenPay y crear planes de suscripción
2. Implementar subida de imágenes (Cloudinary/AWS S3)
3. Agregar más páginas del panel artista/cliente/admin
4. Implementar notificaciones en tiempo real
5. Agregar más filtros de búsqueda

### Para Producción
1. Configurar variables de entorno de producción
2. Configurar HTTPS
3. Optimizar imágenes
4. Configurar backups de base de datos
5. Configurar monitoreo y logs
6. Implementar pruebas automatizadas

## 📱 App Móvil (Futuro)

La API está diseñada para ser consumida por aplicaciones móviles. La estructura RESTful permite fácil integración con:
- React Native
- Flutter
- NativeScript-Vue

## 📄 Licencia

Este proyecto es privado y de uso interno.

## 👥 Equipo

Desarrollado para PUNTO TATTO 2026

---

**Nota**: Este es un proyecto en desarrollo activo. Algunas funcionalidades pueden estar en construcción.

# Guía de Configuración Rápida - PUNTO TATTO

## ⚡ Inicio Rápido

### 1. Base de Datos

Crea una base de datos PostgreSQL:

```sql
CREATE DATABASE punto_tatto;
```

### 2. Backend - Laravel

```bash
cd backend

# Instalar dependencias
composer install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Editar .env con tus credenciales
# DB_DATABASE=punto_tatto
# DB_USERNAME=tu_usuario
# DB_PASSWORD=tu_contraseña

# Migraciones y seeders
php artisan migrate
php artisan db:seed

# Iniciar servidor
php artisan serve
```

### 3. Frontend - Nuxt 3

```bash
cd frontend

# Instalar dependencias
npm install

# Iniciar servidor de desarrollo
npm run dev
```

### 4. Acceso

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8000/api
- **Admin Login**: 
  - Email: `admin@puntotatto.com`
  - Password: `admin123`

## 📝 Configuración OpenPay

1. Crea una cuenta en OpenPay
2. Obtén tus credenciales (Merchant ID, Private Key, Public Key)
3. Agrega en `backend/.env`:

```env
OPENPAY_MERCHANT_ID=tu_merchant_id
OPENPAY_PRIVATE_KEY=tu_private_key
OPENPAY_PUBLIC_KEY=tu_public_key
OPENPAY_PRODUCTION=false
```

4. Crea planes de suscripción en OpenPay para cada membresía (Básico, Premium, VIP)
5. Guarda los `plan_id` de OpenPay en la base de datos o agrega un campo `openpay_plan_id` en la tabla `memberships`

## 🔐 Usuario Admin por Defecto

Después de ejecutar los seeders, puedes iniciar sesión con:
- **Email**: admin@puntotatto.com
- **Contraseña**: admin123

⚠️ **IMPORTANTE**: Cambia esta contraseña inmediatamente en producción.

## 🚀 Comandos Útiles

### Backend
```bash
# Migrar base de datos
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Limpiar caché
php artisan cache:clear
php artisan config:clear

# Crear usuario admin
php artisan tinker
>>> $user = new App\Models\User();
>>> $user->name = 'Admin';
>>> $user->email = 'admin@example.com';
>>> $user->password = Hash::make('password');
>>> $user->role = 'admin';
>>> $user->save();
```

### Frontend
```bash
# Desarrollo
npm run dev

# Producción
npm run build
npm run preview
```

## 📚 Estructura de Archivos Importantes

### Backend
- `routes/api.php` - Rutas de la API
- `app/Http/Controllers/Api/` - Controladores
- `app/Models/` - Modelos Eloquent
- `database/migrations/` - Migraciones
- `database/seeders/` - Seeders

### Frontend
- `pages/` - Páginas/vistas
- `components/` - Componentes Vue
- `stores/` - Stores Pinia
- `layouts/` - Layouts
- `utils/api.js` - Cliente API

## 🐛 Solución de Problemas

### Error: "SQLSTATE[HY000] [2002] Connection refused"
- Verifica que PostgreSQL esté corriendo
- Revisa las credenciales en `.env`

### Error: "Class 'App\Http\Controllers\...' not found"
- Ejecuta: `composer dump-autoload`

### Error: Frontend no se conecta al backend
- Verifica que `API_BASE_URL` en frontend apunte a `http://localhost:8000/api`
- Revisa CORS en `backend/config/cors.php`

### Error: "419 Page Expired" o problemas con tokens
- Verifica que `SANCTUM_STATEFUL_DOMAINS` en `.env` incluya `localhost:3000`
- Limpia caché: `php artisan cache:clear`

## 📱 Próximos Pasos

1. ✅ Configurar OpenPay completamente
2. ✅ Implementar subida de imágenes (Cloudinary/S3)
3. ✅ Completar páginas faltantes en los paneles
4. ✅ Agregar notificaciones en tiempo real
5. ✅ Implementar pruebas
6. ✅ Configurar para producción

## 💡 Tips

- Usa `php artisan tinker` para probar modelos y relaciones
- Revisa los logs en `storage/logs/laravel.log`
- Usa las DevTools de Nuxt para debugging
- Configura `.env` correctamente antes de empezar


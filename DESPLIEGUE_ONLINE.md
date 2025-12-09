# 🌐 Desplegar PUNTO TATTO en Línea

## 🎯 Opciones de Despliegue

### Opción 1: Railway (Recomendada - Más Fácil)
Railway puede ejecutar todo: Backend, Frontend y PostgreSQL en un solo lugar.

### Opción 2: Vercel (Frontend) + Railway/Render (Backend)
Frontend en Vercel y Backend en Railway o Render.

### Opción 3: GitHub Codespaces
Ejecutar todo en un entorno de desarrollo en la nube.

## 🚀 Opción 1: Railway (TODO EN UNO)

Railway es la forma más fácil de desplegar todo el proyecto.

### Pasos:

1. **Ir a Railway:**
   - Ve a: https://railway.app
   - Inicia sesión con GitHub
   - Click en "New Project"

2. **Conectar Repositorio:**
   - Selecciona "Deploy from GitHub repo"
   - Conecta tu repositorio: `cotero1492/punto-tatto`

3. **Desplegar Backend:**
   - Railway detectará automáticamente el backend
   - O crea un servicio manual:
     - Click en "+ New" → "GitHub Repo"
     - Selecciona tu repo
     - Root Directory: `backend`
     - Build Command: `composer install`
     - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

4. **Agregar PostgreSQL:**
   - Click en "+ New" → "Database" → "PostgreSQL"
   - Railway creará automáticamente las variables de entorno

5. **Configurar Variables de Entorno (Backend):**
   ```
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=pgsql
   DB_HOST=${{Postgres.PGHOST}}
   DB_PORT=${{Postgres.PGPORT}}
   DB_DATABASE=${{Postgres.PGDATABASE}}
   DB_USERNAME=${{Postgres.PGUSER}}
   DB_PASSWORD=${{Postgres.PGPASSWORD}}
   FRONTEND_URL=https://tu-frontend.vercel.app
   ```

6. **Ejecutar Migraciones:**
   - En Railway, ve a tu servicio backend
   - Abre la terminal
   - Ejecuta: `php artisan migrate --force`
   - Ejecuta: `php artisan db:seed --force`

7. **Desplegar Frontend:**
   - Click en "+ New" → "GitHub Repo"
   - Selecciona tu repo
   - Root Directory: `frontend`
   - Build Command: `npm install && npm run build`
   - Start Command: `npm run preview`
   - Variables de entorno:
     ```
     API_BASE_URL=https://tu-backend.railway.app/api
     ```

8. **Obtener URLs:**
   - Railway te dará URLs públicas automáticamente
   - Ejemplo: `https://tu-backend.railway.app`
   - Ejemplo: `https://tu-frontend.railway.app`

## 🚀 Opción 2: Vercel (Frontend) + Railway (Backend)

### Frontend en Vercel:

1. **Ir a Vercel:**
   - Ve a: https://vercel.com
   - Inicia sesión con GitHub

2. **Importar Proyecto:**
   - Click en "Add New" → "Project"
   - Selecciona tu repositorio
   - Root Directory: `frontend`
   - Framework Preset: Nuxt.js
   - Build Command: `npm run build`
   - Output Directory: `.output/public`

3. **Variables de Entorno:**
   ```
   API_BASE_URL=https://tu-backend.railway.app/api
   ```

4. **Deploy:**
   - Click en "Deploy"
   - Vercel te dará una URL: `https://tu-proyecto.vercel.app`

### Backend en Railway (mismo proceso que arriba)

## 🚀 Opción 3: Render

### Backend en Render:

1. **Ir a Render:**
   - Ve a: https://render.com
   - Inicia sesión con GitHub

2. **Nuevo Web Service:**
   - Connect your repository: `cotero1492/punto-tatto`
   - Root Directory: `backend`
   - Environment: PHP
   - Build Command: `composer install`
   - Start Command: `php -S 0.0.0.0:$PORT -t public`

3. **Agregar PostgreSQL:**
   - New → PostgreSQL
   - Render creará automáticamente la base de datos

4. **Variables de Entorno:**
   - Misma configuración que Railway

### Frontend en Render:

1. **Nuevo Static Site:**
   - Root Directory: `frontend`
   - Build Command: `npm install && npm run build`
   - Publish Directory: `.output/public`

## 🔧 Configuración Necesaria

### Variables de Entorno para Backend:

```env
APP_NAME="PUNTO TATTO API"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:TU_CLAVE_AQUI
APP_URL=https://tu-backend.railway.app

DB_CONNECTION=pgsql
DB_HOST=tu-host-postgres
DB_PORT=5432
DB_DATABASE=tu-database
DB_USERNAME=tu-usuario
DB_PASSWORD=tu-password

FRONTEND_URL=https://tu-frontend.vercel.app

OPENPAY_MERCHANT_ID=tu_merchant_id
OPENPAY_PRIVATE_KEY=tu_private_key
OPENPAY_PUBLIC_KEY=tu_public_key
OPENPAY_PRODUCTION=true
```

### Generar APP_KEY:

```bash
php artisan key:generate --show
```

## ✅ Checklist Post-Despliegue

- [ ] Base de datos creada y conectada
- [ ] Migraciones ejecutadas
- [ ] Seeders ejecutados (crear admin)
- [ ] Variables de entorno configuradas
- [ ] CORS configurado (FRONTEND_URL)
- [ ] Backend accesible públicamente
- [ ] Frontend configurado con URL del backend
- [ ] Probar login y funcionalidades básicas

## 🔗 URLs de Ejemplo

Después del despliegue tendrás:
- **Backend API**: `https://tu-backend.railway.app/api`
- **Frontend**: `https://tu-proyecto.vercel.app`
- **Admin**: `https://tu-proyecto.vercel.app/login` (admin@puntotatto.com / admin123)

## 💡 Recomendación

Para empezar rápido, usa **Railway** que maneja todo automáticamente.


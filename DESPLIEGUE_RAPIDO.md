# ⚡ Despliegue Rápido - Railway (5 minutos)

## 🎯 Método Más Rápido: Railway

Railway puede desplegar todo automáticamente.

### Paso 1: Crear Cuenta en Railway

1. Ve a: https://railway.app
2. Click en "Login" → "Login with GitHub"
3. Autoriza Railway a acceder a tus repositorios

### Paso 2: Desplegar Backend

1. Click en **"+ New Project"**
2. Selecciona **"Deploy from GitHub repo"**
3. Busca y selecciona: `cotero1492/punto-tatto`
4. Railway detectará automáticamente el backend
5. O crea manualmente:
   - Click en **"+ New"** → **"GitHub Repo"**
   - Root Directory: `backend`
   - Dejar configuración por defecto

### Paso 3: Agregar PostgreSQL

1. En tu proyecto Railway, click en **"+ New"**
2. Selecciona **"Database"** → **"Add PostgreSQL"**
3. Railway creará automáticamente la base de datos

### Paso 4: Configurar Variables de Entorno (Backend)

1. Ve a tu servicio Backend → **Variables**
2. Agrega estas variables:

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}
FRONTEND_URL=https://tu-frontend.vercel.app
```

**Importante**: Genera `APP_KEY`:
- En Railway, abre la terminal del backend
- Ejecuta: `php artisan key:generate --show`
- Copia la clave y pégala en `APP_KEY`

### Paso 5: Ejecutar Migraciones

1. En Railway, ve a tu servicio Backend
2. Click en **"Deploy Logs"** → **"View Logs"** → **"Open Shell"**
3. Ejecuta:
```bash
php artisan migrate --force
php artisan db:seed --force
```

### Paso 6: Obtener URL del Backend

1. Ve a tu servicio Backend → **Settings**
2. Busca **"Generate Domain"**
3. Copia la URL (ejemplo: `https://tu-backend.up.railway.app`)

### Paso 7: Desplegar Frontend en Vercel

1. Ve a: https://vercel.com
2. Login con GitHub
3. **"Add New"** → **"Project"**
4. Selecciona: `cotero1492/punto-tatto`
5. Configuración:
   - **Root Directory**: `frontend`
   - **Framework Preset**: Nuxt.js
   - **Build Command**: `npm run build`
   - **Output Directory**: `.output/public`
6. **Environment Variables**:
   ```
   API_BASE_URL=https://tu-backend.up.railway.app/api
   ```
   (Reemplaza con la URL real de tu backend)
7. Click en **"Deploy"**

### Paso 8: Actualizar FRONTEND_URL en Backend

1. Vuelve a Railway → Backend → Variables
2. Actualiza `FRONTEND_URL` con la URL de Vercel
3. Reinicia el servicio

## ✅ Listo!

Tu proyecto estará en línea:
- **Backend**: `https://tu-backend.up.railway.app`
- **Frontend**: `https://tu-proyecto.vercel.app`

## 🔑 Login

- **URL**: Tu URL de Vercel
- **Email**: `admin@puntotatto.com`
- **Password**: `admin123`

## 🔄 Para Actualizar

Cada vez que hagas cambios y hagas push a GitHub:
- **Railway**: Se despliega automáticamente
- **Vercel**: Se despliega automáticamente


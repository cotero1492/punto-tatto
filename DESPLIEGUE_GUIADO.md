# 🎯 Despliegue Guiado Paso a Paso

## ✅ Ya tienes:
- ✅ Railway CLI instalado
- ✅ Vercel CLI instalado
- ✅ Repositorio en GitHub
- ✅ Archivos de configuración listos

## 🚀 Pasos para Desplegar (5 minutos)

### PASO 1: Desplegar Backend en Railway

1. **Abre Railway:**
   - Ve a: https://railway.app
   - Inicia sesión con GitHub (si no lo has hecho)

2. **Crear Nuevo Proyecto:**
   - Click en **"+ New Project"**
   - Selecciona **"Deploy from GitHub repo"**
   - Busca y selecciona: **`cotero1492/punto-tatto`**
   - Railway mostrará opciones de despliegue

3. **Configurar Backend:**
   - Railway puede detectar automáticamente el backend
   - O crea manualmente:
     - Click en **"+ New"** → **"GitHub Repo"**
     - Root Directory: **`backend`**
     - Dejar todo lo demás por defecto

4. **Agregar Base de Datos:**
   - En tu proyecto Railway, click en **"+ New"**
   - Selecciona **"Database"** → **"Add PostgreSQL"**
   - Railway creará la base de datos automáticamente

5. **Configurar Variables de Entorno:**
   - Ve a tu servicio Backend → **Variables**
   - Click en **"+ New Variable"**
   - Agrega estas variables:
     ```
     APP_ENV=production
     APP_DEBUG=false
     APP_KEY=
     DB_CONNECTION=pgsql
     ```
   - Para las variables de DB, usa los valores que Railway creó automáticamente:
     ```
     DB_HOST=${{Postgres.PGHOST}}
     DB_PORT=${{Postgres.PGPORT}}
     DB_DATABASE=${{Postgres.PGDATABASE}}
     DB_USERNAME=${{Postgres.PGUSER}}
     DB_PASSWORD=${{Postgres.PGPASSWORD}}
     ```

6. **Generar APP_KEY:**
   - En Railway, ve a tu servicio Backend
   - Click en **"View Logs"** → **"Open Shell"**
   - Ejecuta: `php artisan key:generate --show`
   - Copia la clave que aparece
   - Vuelve a **Variables** y pega la clave en `APP_KEY`

7. **Ejecutar Migraciones:**
   - En la misma terminal/shell de Railway:
     ```bash
     php artisan migrate --force
     php artisan db:seed --force
     ```

8. **Obtener URL del Backend:**
   - Ve a **Settings** → **Networking**
   - Click en **"Generate Domain"**
   - Copia la URL (ejemplo: `https://punto-tatto-backend.up.railway.app`)

### PASO 2: Desplegar Frontend en Vercel

1. **Abre Vercel:**
   - Ve a: https://vercel.com
   - Inicia sesión con GitHub

2. **Importar Proyecto:**
   - Click en **"Add New"** → **"Project"**
   - Busca: **`cotero1492/punto-tatto`**
   - Click en **"Import"**

3. **Configurar Proyecto:**
   - **Root Directory**: Cambia a `frontend`
   - **Framework Preset**: Nuxt.js (debería detectarse automáticamente)
   - **Build Command**: `npm run build`
   - **Output Directory**: `.output/public`

4. **Agregar Variable de Entorno:**
   - En la sección **"Environment Variables"**
   - Click en **"+ Add"**
   - **Key**: `API_BASE_URL`
   - **Value**: `https://tu-backend.railway.app/api` (usa la URL que copiaste del paso 1.8)
   - Click en **"Add"**

5. **Desplegar:**
   - Click en **"Deploy"**
   - Espera a que termine (1-2 minutos)
   - Vercel te dará una URL (ejemplo: `https://punto-tatto.vercel.app`)

### PASO 3: Actualizar FRONTEND_URL en Backend

1. Vuelve a **Railway** → Backend → **Variables**
2. Agrega o actualiza:
   ```
   FRONTEND_URL=https://tu-frontend.vercel.app
   ```
   (usa la URL que te dio Vercel)

### PASO 4: Verificar

1. Visita tu frontend: `https://tu-frontend.vercel.app`
2. Intenta iniciar sesión:
   - Email: `admin@puntotatto.com`
   - Password: `admin123`

## ✅ ¡Listo!

Tu proyecto está en línea y funcionando.

## 🔄 Para Actualizar

Cada vez que hagas cambios:
- **Railway**: Se despliega automáticamente cuando haces push a GitHub
- **Vercel**: Se despliega automáticamente cuando haces push a GitHub

## 🆘 Problemas Comunes

**Error de conexión a la base de datos:**
- Verifica que las variables de DB usen `${{Postgres.XXX}}`
- Asegúrate de que PostgreSQL esté activo

**Frontend no se conecta al backend:**
- Verifica que `API_BASE_URL` en Vercel sea correcta
- Verifica que `FRONTEND_URL` en Railway sea correcta
- Revisa CORS en `backend/config/cors.php`

**Error 500 en backend:**
- Verifica que `APP_KEY` esté configurado
- Revisa los logs en Railway
- Verifica que las migraciones se ejecutaron


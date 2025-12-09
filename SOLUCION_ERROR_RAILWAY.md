# 🔧 Solución Error en Railway

## ⚠️ Error: "There was an error deploying from source"

### Posibles Causas y Soluciones

### 1. Railway no detecta el backend correctamente

**Solución:** Configura el servicio manualmente

1. En Railway Dashboard:
   - Click en tu proyecto
   - Click en **"+ New"** → **"GitHub Repo"**
   - Selecciona: `cotero1492/punto-tatto`
   - **Root Directory**: `backend` ⚠️ IMPORTANTE
   - Deja el resto por defecto

### 2. Falta configuración de PHP

**Solución:** Railway debería detectar PHP automáticamente, pero asegúrate de tener:

- `composer.json` en el directorio backend
- `Procfile` o `railway.json` configurado

### 3. Variables de entorno faltantes

**Solución:** Configura estas variables en Railway:

1. Ve a tu servicio backend → **Variables**
2. Agrega:
   ```
   APP_ENV=production
   APP_DEBUG=false
   PORT=${{PORT}}
   ```

### 4. Error en el build

**Solución:** Revisa los logs

1. En Railway → Tu servicio → **Deploy Logs**
2. Busca el error específico
3. Errores comunes:
   - **"composer install failed"**: Verifica composer.json
   - **"php not found"**: Railway debería detectarlo automáticamente
   - **"port binding failed"**: Verifica que uses `$PORT`

### 5. Configuración Manual Paso a Paso

Si Railway no detecta automáticamente:

1. **Crear servicio manualmente:**
   ```
   Railway Dashboard → + New → GitHub Repo
   Repositorio: cotero1492/punto-tatto
   Root Directory: backend
   ```

2. **Verificar build settings:**
   - Build Command: (dejar vacío, Railway lo detectará)
   - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

3. **Configurar variables:**
   - Ve a Variables y agrega las necesarias

### 6. Verificar Archivos Necesarios

Asegúrate de tener estos archivos en `backend/`:

- ✅ `composer.json`
- ✅ `Procfile` o `railway.json`
- ✅ `artisan`
- ✅ `bootstrap/app.php`

### 7. Build Command Explícito

Si sigue fallando, en Railway:

1. Ve a **Settings** → **Build & Deploy**
2. **Build Command**: `composer install --no-dev --optimize-autoloader`
3. **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

## 🔍 Revisar Logs de Error

Para diagnosticar mejor, revisa los logs:

1. Railway Dashboard → Tu servicio
2. Click en **"Deploy Logs"**
3. Busca el error específico
4. Comparte el error para ayudarte mejor

## ✅ Configuración Recomendada

### Backend en Railway:

**Settings:**
- Root Directory: `backend`
- Build Command: (automático o `composer install`)
- Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

**Variables de Entorno:**
```
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}
FRONTEND_URL=https://punto-tatto.vercel.app
```

## 📞 Si el Error Persiste

Comparte:
1. El error exacto de los logs de Railway
2. Una captura de la configuración del servicio
3. Qué comando de build/start estás usando


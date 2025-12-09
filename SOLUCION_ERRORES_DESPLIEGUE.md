# 🔧 Solución de Errores de Despliegue

## ✅ Frontend en Vercel

**URL**: https://punto-tatto.vercel.app

El frontend está desplegado. Si muestra 404 o error, verifica:

### Verificar Frontend:

1. **Abre en navegador**: https://punto-tatto.vercel.app
2. **Abre DevTools** (F12) → **Console**
3. **Busca errores** relacionados con la API

### Problema común: Frontend no se conecta al backend

**Solución:**
1. Ve a Vercel Dashboard → Tu proyecto → **Settings** → **Environment Variables**
2. Verifica que existe:
   ```
   API_BASE_URL=https://tu-backend.railway.app/api
   ```
3. Si no existe, agrégala
4. **Redeploy** el proyecto

## ❌ Backend en Railway - Error

### Error: "There was an error deploying from source"

### Solución 1: Verificar Root Directory

**IMPORTANTE**: Railway necesita saber que el backend está en la carpeta `backend/`

1. En Railway Dashboard:
   - Ve a tu servicio backend
   - Click en **Settings**
   - Busca **"Root Directory"**
   - Debe decir: `backend`
   - Si dice `/` o está vacío, cámbialo a `backend`

### Solución 2: Crear Servicio Manualmente

Si Railway no detecta automáticamente:

1. **Elimina** el servicio actual (si existe)
2. Click en **"+ New"** → **"GitHub Repo"**
3. Selecciona: `cotero1492/punto-tatto`
4. **Root Directory**: `backend` ⚠️ MUY IMPORTANTE
5. Click en **"Deploy"**

### Solución 3: Verificar Logs

1. En Railway → Tu servicio backend
2. Click en **"Deploy Logs"**
3. Busca el error específico
4. Errores comunes:

**"composer.json not found"**
- Verifica que Root Directory sea `backend`

**"php not found"**
- Railway debería detectar PHP automáticamente
- Verifica que `composer.json` esté presente

**"Port binding failed"**
- Verifica Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

### Solución 4: Variables de Entorno

Asegúrate de tener estas variables en Railway:

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

### Solución 5: Build Command Explícito

En Railway → Settings → Build & Deploy:

**Build Command:**
```
composer install --no-dev --optimize-autoloader --no-interaction
```

**Start Command:**
```
php artisan serve --host=0.0.0.0 --port=$PORT
```

## 📋 Checklist de Verificación

### Backend (Railway):
- [ ] Root Directory configurado como `backend`
- [ ] PostgreSQL agregado y activo
- [ ] Variables de entorno configuradas
- [ ] Build command correcto
- [ ] Start command usa `$PORT`
- [ ] Logs no muestran errores fatales

### Frontend (Vercel):
- [ ] Root Directory configurado como `frontend`
- [ ] Variable `API_BASE_URL` configurada
- [ ] Build exitoso
- [ ] No hay errores en la consola del navegador

## 🔍 Revisar Error Específico

Para ayudarte mejor, comparte:

1. **El error exacto** de los logs de Railway
2. **Configuración actual**:
   - Root Directory
   - Build Command
   - Start Command
   - Variables de entorno

## 🚀 Pasos Recomendados

1. **Verifica Root Directory** en Railway (debe ser `backend`)
2. **Revisa los logs** de Railway para el error exacto
3. **Asegúrate** de que PostgreSQL esté agregado
4. **Configura variables** de entorno
5. **Redeploy** el servicio

## 📞 Si el Error Persiste

Comparte:
- Captura de los logs de Railway
- Configuración actual del servicio
- Error exacto que aparece


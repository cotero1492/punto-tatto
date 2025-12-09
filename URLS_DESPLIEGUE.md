# 🌐 URLs de Tu Aplicación Desplegada

## ✅ Frontend (Vercel)

**URL Principal:**
```
https://punto-tatto-git-main-marcos-projects-b0ac3837.vercel.app/
```

**Nota:** Esta es una URL temporal de preview. Vercel también debería tener una URL de producción permanente.

### Para obtener la URL de producción:

1. Ve a: https://vercel.com
2. Click en tu proyecto "punto-tatto"
3. En el dashboard, busca la sección de **"Domains"** o **"Production Deployment"**
4. La URL de producción será algo como:
   ```
   https://punto-tatto.vercel.app
   ```

## 🔧 Configuración Importante

### 1. Variable de Entorno en Vercel

Asegúrate de tener configurada la variable de entorno:

**En Vercel Dashboard:**
1. Ve a tu proyecto → **Settings** → **Environment Variables**
2. Agrega o verifica:
   - **Key**: `NUXT_PUBLIC_API_BASE`
   - **Value**: `https://tu-backend.up.railway.app/api`
   - Marca todas las opciones (Production, Preview, Development)

**Ejemplo:**
```
NUXT_PUBLIC_API_BASE=https://punto-tatto-production.up.railway.app/api
```

### 2. URL del Backend en Railway

Necesitas encontrar la URL de tu backend en Railway:

1. Ve a: https://railway.app
2. Click en tu proyecto
3. Click en el servicio **Backend**
4. Ve a **Settings** → **Networking**
5. Copia la URL (ejemplo: `https://punto-tatto-production.up.railway.app`)

### 3. Actualizar FRONTEND_URL en Railway

En Railway → Backend → Variables, agrega:
```
FRONTEND_URL=https://punto-tatto-git-main-marcos-projects-b0ac3837.vercel.app
```

O mejor aún, usa la URL de producción cuando la obtengas:
```
FRONTEND_URL=https://punto-tatto.vercel.app
```

## ✅ Verificar que Todo Funcione

### 1. Probar Frontend

Visita: https://punto-tatto-git-main-marcos-projects-b0ac3837.vercel.app/

Deberías ver:
- ✅ La página de inicio cargando
- ✅ Sin errores en la consola del navegador (F12)
- ✅ La aplicación funcionando

### 2. Probar Backend

Si tienes la URL del backend, prueba:
- API Root: `https://tu-backend.up.railway.app/`
- Healthcheck: `https://tu-backend.up.railway.app/up`
- API Pública: `https://tu-backend.up.railway.app/api/public/artists`

### 3. Probar Conexión Frontend-Backend

1. Abre tu frontend en el navegador
2. Abre la consola (F12 → Console)
3. Intenta hacer login o registrar un usuario
4. Verifica que no haya errores de CORS o conexión

## 🔄 Dominio Personalizado (Opcional)

Si quieres un dominio personalizado:

### En Vercel:
1. Settings → Domains
2. Agrega tu dominio personalizado
3. Sigue las instrucciones de DNS

### En Railway:
1. Settings → Networking
2. Agrega tu dominio personalizado
3. Configura los registros DNS

## 📝 Notas

- Las URLs de preview de Vercel cambian con cada deployment
- La URL de producción es permanente
- Asegúrate de que las variables de entorno estén configuradas correctamente
- Si cambias algo, haz un nuevo deployment en ambos servicios

## 🚨 Si Algo No Funciona

### Frontend no carga:
- Verifica que el deployment haya terminado en Vercel
- Revisa los logs en Vercel Dashboard

### Frontend no se conecta al backend:
- Verifica que `NUXT_PUBLIC_API_BASE` esté configurada
- Verifica que `FRONTEND_URL` esté configurada en Railway
- Verifica que el backend esté funcionando

### Errores de CORS:
- Asegúrate de que `FRONTEND_URL` en Railway coincida con la URL de Vercel
- Verifica la configuración de CORS en `backend/config/cors.php`

¡Tu aplicación está desplegada! 🎉


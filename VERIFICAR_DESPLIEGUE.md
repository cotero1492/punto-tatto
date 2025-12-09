# ✅ Verificar Despliegue

## 🔍 Para Verificar que Todo Funciona

### Opción 1: Verificación Automática

Si tienes las URLs, ejecuta:

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"
./verificar-urls.sh
```

O proporciona las URLs directamente:

```bash
./verificar-urls.sh https://tu-backend.railway.app https://tu-frontend.vercel.app
```

### Opción 2: Verificación Manual

#### 1. Verifica Backend (Railway)

Abre en tu navegador o terminal:

```
https://tu-backend.railway.app/api/public/artists
```

**Debería mostrar:**
- JSON con lista de artistas (puede estar vacío si no hay datos)
- O un objeto JSON válido

**Si ves error 404 o 500:**
- Verifica que las migraciones se ejecutaron
- Revisa los logs en Railway

#### 2. Verifica Frontend (Vercel)

Abre en tu navegador:

```
https://tu-frontend.vercel.app
```

**Debería mostrar:**
- La página principal del sitio
- No errores en la consola del navegador

**Para probar funcionalidades:**
1. Click en "Explorar Artistas"
2. Intenta iniciar sesión:
   - Email: `admin@puntotatto.com`
   - Password: `admin123`

#### 3. Verificar Conexión Frontend-Backend

1. Abre el frontend en el navegador
2. Abre las **DevTools** (F12)
3. Ve a la pestaña **Network**
4. Navega por el sitio
5. Verifica que las peticiones a `/api/` sean exitosas

### Checklist de Verificación

- [ ] Backend responde en Railway
- [ ] Frontend carga en Vercel
- [ ] API pública funciona (`/api/public/artists`)
- [ ] Frontend se conecta al backend
- [ ] Login funciona
- [ ] No hay errores CORS en la consola
- [ ] Las migraciones se ejecutaron
- [ ] El usuario admin existe

### 🔧 Si Algo No Funciona

**Backend no responde:**
- Revisa logs en Railway Dashboard
- Verifica que el servicio esté "Active"
- Verifica variables de entorno

**Frontend no se conecta al backend:**
- Verifica `API_BASE_URL` en Vercel
- Verifica `FRONTEND_URL` en Railway
- Revisa CORS en backend

**Error 500:**
- Revisa logs en Railway
- Verifica que `APP_KEY` esté configurado
- Verifica conexión a base de datos

**CORS errors:**
- Verifica `FRONTEND_URL` en Railway
- Verifica configuración en `backend/config/cors.php`


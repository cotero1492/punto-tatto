# 🚀 Comandos para Desplegar en Línea

## ✅ Herramientas Instaladas

- ✅ Railway CLI instalado
- ✅ Vercel CLI instalado

## 🎯 Opción 1: Script Automático

Ejecuta:

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"
./desplegar-ahora.sh
```

Este script hará todo automáticamente (requiere autenticación).

## 🎯 Opción 2: Manual Paso a Paso

### Backend en Railway:

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"

# 1. Autenticar (abrirá navegador)
railway login

# 2. Crear proyecto
railway init --name "punto-tatto"

# 3. Ir al backend
cd backend

# 4. Vincular servicio
railway link

# 5. Agregar PostgreSQL
railway add --database postgres

# 6. Configurar variables
railway variables set APP_ENV=production
railway variables set APP_DEBUG=false

# 7. Generar APP_KEY
railway run php artisan key:generate --show
# Copia la clave y pégala:
railway variables set APP_KEY="la_clave_generada"

# 8. Ejecutar migraciones
railway run php artisan migrate --force

# 9. Ejecutar seeders
railway run php artisan db:seed --force

# 10. Desplegar
railway up

# 11. Obtener URL
railway domain
```

### Frontend en Vercel:

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026/frontend"

# 1. Autenticar
vercel login

# 2. Desplegar
vercel --prod

# 3. Configurar variable de entorno
# En Vercel Dashboard → Settings → Environment Variables
# Agrega: API_BASE_URL = https://tu-backend.railway.app/api
```

## 🎯 Opción 3: Desde Interfaz Web (Más Fácil)

### Railway (Backend):

1. Ve a: https://railway.app
2. Click en "New Project"
3. Selecciona "Deploy from GitHub repo"
4. Conecta: `cotero1492/punto-tatto`
5. Root Directory: `backend`
6. Railway detectará y desplegará automáticamente
7. Agrega PostgreSQL desde el dashboard
8. Configura variables de entorno
9. Ejecuta migraciones desde la terminal de Railway

### Vercel (Frontend):

1. Ve a: https://vercel.com
2. Click en "Add New Project"
3. Selecciona: `cotero1492/punto-tatto`
4. Root Directory: `frontend`
5. Framework: Nuxt.js
6. Agrega variable: `API_BASE_URL`
7. Click en "Deploy"

## 📋 Checklist

- [ ] Backend desplegado en Railway
- [ ] PostgreSQL agregado
- [ ] Variables de entorno configuradas
- [ ] APP_KEY generado
- [ ] Migraciones ejecutadas
- [ ] Seeders ejecutados
- [ ] Backend URL obtenida
- [ ] Frontend desplegado en Vercel
- [ ] API_BASE_URL configurada en frontend
- [ ] FRONTEND_URL configurada en backend
- [ ] Probar login y funcionalidades

## 🔗 URLs Finales

Después del despliegue:
- **Backend**: `https://tu-backend.up.railway.app`
- **Frontend**: `https://tu-proyecto.vercel.app`


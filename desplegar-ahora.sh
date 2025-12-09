#!/bin/bash

echo "🚀 Despliegue de PUNTO TATTO"
echo "============================"
echo ""

cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"

# Verificar herramientas
if ! command -v railway &> /dev/null; then
    echo "❌ Railway CLI no instalado"
    echo "Instalando..."
    npm install -g @railway/cli
fi

if ! command -v vercel &> /dev/null; then
    echo "❌ Vercel CLI no instalado"
    echo "Instalando..."
    npm install -g vercel
fi

echo "✅ Herramientas instaladas"
echo ""

# Autenticar Railway
echo "🔐 Paso 1/4: Autenticación en Railway"
echo "--------------------------------------"
echo "Se abrirá tu navegador para autenticarte..."
railway login

if [ $? -ne 0 ]; then
    echo "⚠️  Error en autenticación de Railway"
    echo "Por favor autentícate manualmente: railway login"
    exit 1
fi

# Crear proyecto en Railway
echo ""
echo "📦 Paso 2/4: Crear proyecto en Railway"
echo "--------------------------------------"
echo "Creando nuevo proyecto..."
railway init --name "punto-tatto"

# Desplegar backend
echo ""
echo "🔧 Paso 3/4: Desplegar Backend"
echo "--------------------------------------"
cd backend

echo "Vinculando servicio backend..."
railway link

echo "Agregando PostgreSQL..."
railway add --database postgres

echo "Configurando variables de entorno..."
# Railway debería detectar automáticamente las variables de la base de datos
railway variables set APP_ENV=production
railway variables set APP_DEBUG=false
railway variables set FRONTEND_URL=https://tu-frontend.vercel.app

echo "Desplegando backend..."
railway up

cd ..

# Obtener URL del backend
BACKEND_URL=$(railway domain)
echo ""
echo "✅ Backend desplegado en: $BACKEND_URL"

# Desplegar frontend en Vercel
echo ""
echo "🎨 Paso 4/4: Desplegar Frontend"
echo "--------------------------------------"
cd frontend

echo "Autenticando en Vercel..."
vercel login

echo "Desplegando frontend..."
vercel --prod --yes

cd ..

echo ""
echo "✅ ¡Despliegue completado!"
echo ""
echo "📋 URLs:"
echo "   Backend: $BACKEND_URL"
echo "   Frontend: (verifica en Vercel)"
echo ""
echo "🔧 Próximos pasos:"
echo "   1. Genera APP_KEY: railway run php artisan key:generate --show"
echo "   2. Ejecuta migraciones: railway run php artisan migrate --force"
echo "   3. Ejecuta seeders: railway run php artisan db:seed --force"
echo "   4. Actualiza FRONTEND_URL en Railway con la URL de Vercel"


#!/bin/bash

echo "🔍 Verificación de Despliegue - PUNTO TATTO"
echo "============================================"
echo ""

# Verificar Railway
echo "📦 Verificando Railway (Backend)..."
echo "-----------------------------------"

if command -v railway &> /dev/null; then
    railway status 2>&1 | head -20
    echo ""
    
    echo "Obteniendo URL del backend..."
    BACKEND_URL=$(railway domain 2>/dev/null || railway variables get RAILWAY_PUBLIC_DOMAIN 2>/dev/null)
    if [ ! -z "$BACKEND_URL" ]; then
        echo "✅ Backend URL: $BACKEND_URL"
        
        echo ""
        echo "Probando conexión al backend..."
        curl -s -o /dev/null -w "HTTP Status: %{http_code}\n" "https://$BACKEND_URL/api/public/artists" || \
        curl -s -o /dev/null -w "HTTP Status: %{http_code}\n" "$BACKEND_URL/api/public/artists" 2>/dev/null || \
        echo "⚠️  No se pudo conectar al backend"
    else
        echo "⚠️  No se encontró URL del backend"
        echo "Ejecuta: railway domain"
    fi
else
    echo "⚠️  Railway CLI no encontrado"
fi

echo ""
echo "🎨 Verificando Vercel (Frontend)..."
echo "-----------------------------------"

if command -v vercel &> /dev/null; then
    echo "Listando proyectos de Vercel..."
    vercel ls 2>&1 | head -10 || echo "No se encontraron proyectos o no estás autenticado"
    
    echo ""
    echo "Para obtener la URL del frontend, ejecuta:"
    echo "  vercel ls"
    echo "  vercel inspect [nombre-del-proyecto]"
else
    echo "⚠️  Vercel CLI no encontrado"
fi

echo ""
echo "📋 Verificación Manual:"
echo "----------------------"
echo ""
echo "1. Verifica en Railway Dashboard:"
echo "   https://railway.app/dashboard"
echo "   - Busca tu proyecto 'punto-tatto'"
echo "   - Copia la URL del servicio backend"
echo ""
echo "2. Verifica en Vercel Dashboard:"
echo "   https://vercel.com/dashboard"
echo "   - Busca tu proyecto"
echo "   - Copia la URL de producción"
echo ""
echo "3. Prueba las URLs:"
echo "   - Backend: curl https://tu-backend.railway.app/api/public/artists"
echo "   - Frontend: Abre en navegador tu URL de Vercel"
echo ""
echo "✅ Si ambas URLs responden, el despliegue fue exitoso!"


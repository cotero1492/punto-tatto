#!/bin/bash

echo "🔍 Verificación de URLs del Proyecto"
echo "===================================="
echo ""

if [ -z "$1" ] || [ -z "$2" ]; then
    echo "Uso: ./verificar-urls.sh <URL_BACKEND> <URL_FRONTEND>"
    echo ""
    echo "Ejemplo:"
    echo "  ./verificar-urls.sh https://punto-tatto-backend.railway.app https://punto-tatto.vercel.app"
    echo ""
    echo "O proporciona las URLs cuando se solicite:"
    read -p "URL del Backend (Railway): " BACKEND_URL
    read -p "URL del Frontend (Vercel): " FRONTEND_URL
else
    BACKEND_URL=$1
    FRONTEND_URL=$2
fi

echo ""
echo "🔍 Verificando Backend..."
echo "------------------------"

if [ ! -z "$BACKEND_URL" ]; then
    echo "Probando: $BACKEND_URL/api/public/artists"
    
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BACKEND_URL/api/public/artists" 2>/dev/null)
    
    if [ "$HTTP_CODE" == "200" ]; then
        echo "✅ Backend funcionando correctamente (HTTP $HTTP_CODE)"
        
        # Probar obtener datos
        echo ""
        echo "Probando endpoint de artistas..."
        curl -s "$BACKEND_URL/api/public/artists" | head -20
        
    elif [ "$HTTP_CODE" == "000" ]; then
        echo "❌ No se puede conectar al backend"
        echo "   Verifica que la URL sea correcta y que el servicio esté corriendo"
    else
        echo "⚠️  Backend respondió con código HTTP $HTTP_CODE"
        echo "   Esto puede ser normal si no hay datos aún"
    fi
else
    echo "⚠️  No se proporcionó URL del backend"
fi

echo ""
echo "🔍 Verificando Frontend..."
echo "-------------------------"

if [ ! -z "$FRONTEND_URL" ]; then
    echo "Probando: $FRONTEND_URL"
    
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$FRONTEND_URL" 2>/dev/null)
    
    if [ "$HTTP_CODE" == "200" ] || [ "$HTTP_CODE" == "302" ]; then
        echo "✅ Frontend funcionando correctamente (HTTP $HTTP_CODE)"
    elif [ "$HTTP_CODE" == "000" ]; then
        echo "❌ No se puede conectar al frontend"
        echo "   Verifica que la URL sea correcta y que el servicio esté corriendo"
    else
        echo "⚠️  Frontend respondió con código HTTP $HTTP_CODE"
    fi
else
    echo "⚠️  No se proporcionó URL del frontend"
fi

echo ""
echo "📋 Resumen:"
echo "----------"
echo "Backend:  $BACKEND_URL"
echo "Frontend: $FRONTEND_URL"
echo ""
echo "✅ Para probar manualmente:"
echo "   1. Abre el frontend en tu navegador: $FRONTEND_URL"
echo "   2. Intenta iniciar sesión (admin@puntotatto.com / admin123)"
echo "   3. Verifica que puedas ver la lista de artistas"
echo ""


#!/bin/bash

echo "🚀 Despliegue Automático - PUNTO TATTO"
echo "======================================="
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "backend/composer.json" ] || [ ! -f "frontend/package.json" ]; then
    echo "❌ Error: No se encontró el proyecto"
    exit 1
fi

# Verificar Railway CLI
if command -v railway &> /dev/null; then
    echo "✅ Railway CLI encontrado"
    echo ""
    echo "🔧 Configurando despliegue en Railway..."
    
    # Login en Railway
    railway login
    
    # Inicializar proyecto
    railway init
    
    # Desplegar backend
    cd backend
    railway link
    railway up
    
    # Agregar PostgreSQL
    railway add --database postgres
    
    echo ""
    echo "✅ Backend desplegado en Railway"
    echo ""
    
    cd ..
else
    echo "⚠️  Railway CLI no está instalado"
    echo ""
    echo "Instálalo con:"
    echo "  npm install -g @railway/cli"
    echo ""
    echo "O sigue las instrucciones en DESPLIEGUE_RAPIDO.md"
fi

# Verificar Vercel CLI
if command -v vercel &> /dev/null; then
    echo "✅ Vercel CLI encontrado"
    echo ""
    echo "🔧 Configurando despliegue en Vercel..."
    
    cd frontend
    vercel login
    vercel --prod
    
    echo ""
    echo "✅ Frontend desplegado en Vercel"
    echo ""
    
    cd ..
else
    echo "⚠️  Vercel CLI no está instalado"
    echo ""
    echo "Instálalo con:"
    echo "  npm install -g vercel"
    echo ""
    echo "O usa la interfaz web en https://vercel.com"
fi

echo ""
echo "✅ Proceso completado"
echo ""
echo "📋 Próximos pasos:"
echo "   1. Configura las variables de entorno en Railway"
echo "   2. Ejecuta las migraciones en Railway"
echo "   3. Verifica que el frontend apunte al backend correcto"


#!/bin/bash

set -e

echo "⚙️  Configurando proyecto PUNTO TATTO"
echo "======================================"
echo ""

# Verificar que las herramientas estén instaladas
if ! command -v php &> /dev/null || ! command -v composer &> /dev/null || ! command -v node &> /dev/null; then
    echo "❌ Faltan herramientas. Ejecuta primero: ./instalar-todo.sh"
    exit 1
fi

# Backend
echo "📦 Configurando Backend (Laravel)..."
echo "-----------------------------------"
cd backend

if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json no encontrado"
    exit 1
fi

echo "Instalando dependencias PHP..."
composer install

if [ ! -f ".env" ]; then
    echo "Creando archivo .env..."
    cp .env.example .env
    echo ""
    echo "⚠️  IMPORTANTE: Necesitas editar backend/.env con tus credenciales:"
    echo "   - DB_DATABASE=punto_tatto"
    echo "   - DB_USERNAME=tu_usuario_postgres"
    echo "   - DB_PASSWORD=tu_password_postgres"
    echo ""
    read -p "¿Ya configuraste el .env? (s/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[SsYy]$ ]]; then
        echo "Por favor edita backend/.env y ejecuta este script nuevamente."
        exit 1
    fi
fi

echo "Generando clave de aplicación..."
php artisan key:generate || echo "⚠️  Key ya generada"

echo ""
echo "Creando base de datos..."
createdb punto_tatto 2>/dev/null || echo "⚠️  Base de datos ya existe o error al crearla"

echo "Ejecutando migraciones..."
php artisan migrate --force

echo "Ejecutando seeders..."
php artisan db:seed --force

cd ..

# Frontend
echo ""
echo "📦 Configurando Frontend (Nuxt 3)..."
echo "-----------------------------------"
cd frontend

if [ ! -f "package.json" ]; then
    echo "❌ Error: package.json no encontrado"
    exit 1
fi

echo "Instalando dependencias Node.js..."
npm install

cd ..

echo ""
echo "✅ Configuración completada!"
echo ""
echo "🚀 Para iniciar el proyecto:"
echo ""
echo "Terminal 1 - Backend:"
echo "  cd backend && php artisan serve"
echo ""
echo "Terminal 2 - Frontend:"
echo "  cd frontend && npm run dev"
echo ""
echo "O ejecuta: ./iniciar-proyecto.sh"
echo ""


#!/bin/bash

echo "🚀 PUNTO TATTO - Script de Instalación"
echo "======================================"
echo ""

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Verificar Homebrew
if ! command -v brew &> /dev/null; then
    echo -e "${YELLOW}⚠️  Homebrew no está instalado.${NC}"
    echo "Instalando Homebrew..."
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
fi

# Verificar e instalar PHP
if ! command -v php &> /dev/null; then
    echo -e "${YELLOW}📦 Instalando PHP...${NC}"
    brew install php
fi

# Verificar e instalar Composer
if ! command -v composer &> /dev/null; then
    echo -e "${YELLOW}📦 Instalando Composer...${NC}"
    brew install composer
fi

# Verificar e instalar Node.js
if ! command -v node &> /dev/null; then
    echo -e "${YELLOW}📦 Instalando Node.js...${NC}"
    brew install node
fi

# Verificar PostgreSQL
if ! command -v psql &> /dev/null; then
    echo -e "${YELLOW}📦 Instalando PostgreSQL...${NC}"
    brew install postgresql@14
    brew services start postgresql@14
fi

echo ""
echo -e "${GREEN}✅ Todas las dependencias están instaladas${NC}"
echo ""
echo "Siguiente paso:"
echo "1. Configura tu base de datos PostgreSQL"
echo "2. Edita backend/.env con tus credenciales"
echo "3. Ejecuta: cd backend && composer install && php artisan migrate && php artisan db:seed"
echo "4. Ejecuta: cd frontend && npm install && npm run dev"


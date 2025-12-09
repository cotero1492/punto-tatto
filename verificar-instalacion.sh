#!/bin/bash

echo "🔍 Verificando herramientas instaladas..."
echo ""

# Verificar PHP
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -v | head -1)
    echo "✅ PHP: $PHP_VERSION"
else
    echo "❌ PHP: No instalado"
fi

# Verificar Composer
if command -v composer &> /dev/null; then
    COMPOSER_VERSION=$(composer --version | head -1)
    echo "✅ Composer: $COMPOSER_VERSION"
else
    echo "❌ Composer: No instalado"
fi

# Verificar Node.js
if command -v node &> /dev/null; then
    NODE_VERSION=$(node --version)
    echo "✅ Node.js: $NODE_VERSION"
else
    echo "❌ Node.js: No instalado"
fi

# Verificar npm
if command -v npm &> /dev/null; then
    NPM_VERSION=$(npm --version)
    echo "✅ npm: $NPM_VERSION"
else
    echo "❌ npm: No instalado"
fi

# Verificar PostgreSQL
if command -v psql &> /dev/null; then
    PSQL_VERSION=$(psql --version)
    echo "✅ PostgreSQL: $PSQL_VERSION"
else
    echo "❌ PostgreSQL: No instalado"
fi

# Verificar Homebrew
if command -v brew &> /dev/null; then
    BREW_VERSION=$(brew --version | head -1)
    echo "✅ Homebrew: $BREW_VERSION"
else
    echo "❌ Homebrew: No instalado"
fi

echo ""
echo "📋 Resumen:"
echo "Si faltan herramientas, ejecuta: ./install.sh"


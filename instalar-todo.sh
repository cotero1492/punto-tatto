#!/bin/bash

set -e

echo "🚀 Instalación completa de PUNTO TATTO"
echo "======================================"
echo ""
echo "Este script instalará todas las herramientas necesarias."
echo "⚠️  Necesitarás ingresar tu contraseña de administrador cuando se solicite."
echo ""
read -p "¿Continuar? (s/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[SsYy]$ ]]; then
    echo "Instalación cancelada."
    exit 1
fi

# Instalar Homebrew si no existe
if ! command -v brew &> /dev/null; then
    echo ""
    echo "📦 Paso 1/5: Instalando Homebrew..."
    echo "-----------------------------------"
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    
    # Agregar Homebrew al PATH si está en Apple Silicon
    if [ -f "/opt/homebrew/bin/brew" ]; then
        echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/opt/homebrew/bin/brew shellenv)"
    elif [ -f "/usr/local/bin/brew" ]; then
        echo 'eval "$(/usr/local/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/usr/local/bin/brew shellenv)"
    fi
else
    echo "✅ Homebrew ya está instalado"
fi

# Actualizar Homebrew
echo ""
echo "📦 Paso 2/5: Actualizando Homebrew..."
echo "-----------------------------------"
brew update

# Instalar PHP
echo ""
echo "📦 Paso 3/5: Instalando PHP..."
echo "-----------------------------------"
if ! command -v php &> /dev/null; then
    brew install php
else
    echo "✅ PHP ya está instalado"
fi

# Instalar Composer
echo ""
echo "📦 Paso 4/5: Instalando Composer..."
echo "-----------------------------------"
if ! command -v composer &> /dev/null; then
    brew install composer
else
    echo "✅ Composer ya está instalado"
fi

# Instalar Node.js
echo ""
echo "📦 Paso 5/5: Instalando Node.js..."
echo "-----------------------------------"
if ! command -v node &> /dev/null; then
    brew install node
else
    echo "✅ Node.js ya está instalado"
fi

# Instalar PostgreSQL
echo ""
echo "📦 Instalando PostgreSQL..."
echo "-----------------------------------"
if ! command -v psql &> /dev/null; then
    brew install postgresql@14
    brew services start postgresql@14
    echo ""
    echo "✅ PostgreSQL instalado y servicio iniciado"
else
    echo "✅ PostgreSQL ya está instalado"
    brew services start postgresql@14 || true
fi

echo ""
echo "✅ Instalación de herramientas completada!"
echo ""
echo "Ahora ejecuta: ./configurar-proyecto.sh"
echo ""


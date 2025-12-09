#!/bin/bash

echo "🔧 Instalación Manual de Herramientas - PUNTO TATTO"
echo "====================================================="
echo ""

# Verificar si ya están instaladas
echo "🔍 Verificando herramientas existentes..."
echo ""

PHP_INSTALLED=false
COMPOSER_INSTALLED=false
NODE_INSTALLED=false
BREW_INSTALLED=false

if command -v php &> /dev/null; then
    PHP_INSTALLED=true
    echo "✅ PHP ya está instalado: $(php -v | head -1)"
else
    echo "❌ PHP no instalado"
fi

if command -v composer &> /dev/null; then
    COMPOSER_INSTALLED=true
    echo "✅ Composer ya está instalado: $(composer --version | head -1)"
else
    echo "❌ Composer no instalado"
fi

if command -v node &> /dev/null; then
    NODE_INSTALLED=true
    echo "✅ Node.js ya está instalado: $(node --version)"
else
    echo "❌ Node.js no instalado"
fi

if command -v brew &> /dev/null; then
    BREW_INSTALLED=true
    echo "✅ Homebrew ya está instalado: $(brew --version | head -1)"
else
    echo "❌ Homebrew no instalado"
fi

echo ""

# Si todo está instalado, salir
if [ "$PHP_INSTALLED" = true ] && [ "$COMPOSER_INSTALLED" = true ] && [ "$NODE_INSTALLED" = true ]; then
    echo "✅ Todas las herramientas ya están instaladas!"
    exit 0
fi

# Instalar Homebrew si no existe
if [ "$BREW_INSTALLED" = false ]; then
    echo "📦 PASO 1: Instalando Homebrew..."
    echo "───────────────────────────────────────"
    echo "Esto puede tardar varios minutos y requerirá tu contraseña de administrador."
    echo ""
    
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    
    if [ $? -ne 0 ]; then
        echo ""
        echo "❌ Error al instalar Homebrew."
        echo ""
        echo "Por favor ejecuta manualmente:"
        echo "  /bin/bash -c \"\$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)\""
        echo ""
        echo "Luego, al finalizar, ejecuta los comandos que te indique para agregar Homebrew al PATH"
        exit 1
    fi
    
    # Agregar Homebrew al PATH
    if [ -f "/opt/homebrew/bin/brew" ]; then
        echo ""
        echo "Agregando Homebrew al PATH..."
        echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/opt/homebrew/bin/brew shellenv)"
    elif [ -f "/usr/local/bin/brew" ]; then
        echo ""
        echo "Agregando Homebrew al PATH..."
        echo 'eval "$(/usr/local/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/opt/homebrew/bin/brew shellenv)"
    fi
    
    # Verificar que Homebrew funciona
    if ! command -v brew &> /dev/null; then
        echo ""
        echo "⚠️  Homebrew instalado pero no en PATH."
        echo "Por favor ejecuta manualmente los comandos que aparecieron arriba"
        echo "O reinicia tu terminal y ejecuta este script nuevamente."
        exit 1
    fi
    
    echo "✅ Homebrew instalado correctamente"
    echo ""
fi

# Actualizar Homebrew
echo "📦 Actualizando Homebrew..."
brew update

# Instalar PHP
if [ "$PHP_INSTALLED" = false ]; then
    echo ""
    echo "📦 PASO 2: Instalando PHP..."
    echo "───────────────────────────────────────"
    brew install php
    if [ $? -ne 0 ]; then
        echo "❌ Error al instalar PHP"
        exit 1
    fi
    echo "✅ PHP instalado"
fi

# Instalar Composer
if [ "$COMPOSER_INSTALLED" = false ]; then
    echo ""
    echo "📦 PASO 3: Instalando Composer..."
    echo "───────────────────────────────────────"
    brew install composer
    if [ $? -ne 0 ]; then
        echo "❌ Error al instalar Composer"
        exit 1
    fi
    echo "✅ Composer instalado"
fi

# Instalar Node.js
if [ "$NODE_INSTALLED" = false ]; then
    echo ""
    echo "📦 PASO 4: Instalando Node.js..."
    echo "───────────────────────────────────────"
    brew install node
    if [ $? -ne 0 ]; then
        echo "❌ Error al instalar Node.js"
        exit 1
    fi
    echo "✅ Node.js instalado"
fi

# Instalar PostgreSQL
echo ""
echo "📦 PASO 5: Instalando PostgreSQL..."
echo "───────────────────────────────────────"
if ! command -v psql &> /dev/null; then
    brew install postgresql@14
    if [ $? -ne 0 ]; then
        echo "⚠️  Advertencia: Error al instalar PostgreSQL, pero puedes continuar"
    else
        echo "✅ PostgreSQL instalado"
        brew services start postgresql@14 || true
        echo "✅ Servicio de PostgreSQL iniciado"
    fi
else
    echo "✅ PostgreSQL ya instalado"
    brew services start postgresql@14 || true
fi

echo ""
echo "✅ Instalación completada!"
echo ""
echo "📋 Resumen:"
./verificar-instalacion.sh
echo ""
echo "🎯 Siguiente paso:"
echo "   ./configurar-proyecto.sh"


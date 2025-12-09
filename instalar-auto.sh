#!/bin/bash

set -e

echo "🚀 Instalación automática de PUNTO TATTO"
echo "========================================"
echo ""

# Verificar/Instalar Homebrew
if ! command -v brew &> /dev/null; then
    echo "📦 Instalando Homebrew..."
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)" < /dev/null
    
    # Agregar al PATH
    if [ -f "/opt/homebrew/bin/brew" ]; then
        echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/opt/homebrew/bin/brew shellenv)"
    elif [ -f "/usr/local/bin/brew" ]; then
        echo 'eval "$(/usr/local/bin/brew shellenv)"' >> ~/.zprofile
        eval "$(/usr/local/bin/brew shellenv)"
    fi
else
    echo "✅ Homebrew ya instalado"
fi

# Actualizar Homebrew
echo "📦 Actualizando Homebrew..."
brew update

# Instalar herramientas
echo "📦 Instalando PHP..."
brew install php || echo "PHP ya instalado"

echo "📦 Instalando Composer..."
brew install composer || echo "Composer ya instalado"

echo "📦 Instalando Node.js..."
brew install node || echo "Node.js ya instalado"

echo "📦 Instalando PostgreSQL..."
brew install postgresql@14 || echo "PostgreSQL ya instalado"
brew services start postgresql@14 || true

echo ""
echo "✅ Instalación completada!"
echo ""
echo "Ahora ejecuta: ./configurar-proyecto.sh"


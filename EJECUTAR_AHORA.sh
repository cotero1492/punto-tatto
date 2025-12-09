#!/bin/bash

echo "🚀 PUNTO TATTO - Instalación y Configuración"
echo "============================================="
echo ""
echo "Este script requiere permisos de administrador."
echo "Se te solicitará tu contraseña durante la instalación."
echo ""
echo "Presiona ENTER para continuar o Ctrl+C para cancelar..."
read

cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"

# Paso 1: Instalar herramientas
echo ""
echo "📦 PASO 1/4: Instalando herramientas del sistema..."
echo "---------------------------------------------------"
./instalar-auto.sh

if [ $? -ne 0 ]; then
    echo ""
    echo "❌ Error en la instalación de herramientas."
    echo "Por favor ejecuta manualmente:"
    echo "  /bin/bash -c \"\$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)\""
    echo "  brew install php composer node postgresql@14"
    exit 1
fi

# Verificar que las herramientas estén instaladas
if ! command -v php &> /dev/null || ! command -v composer &> /dev/null || ! command -v node &> /dev/null; then
    echo ""
    echo "❌ Algunas herramientas no se instalaron correctamente."
    echo "Por favor instálalas manualmente y vuelve a ejecutar este script."
    exit 1
fi

# Paso 2: Crear base de datos
echo ""
echo "📦 PASO 2/4: Creando base de datos..."
echo "---------------------------------------------------"
createdb punto_tatto 2>/dev/null || echo "⚠️  Base de datos ya existe o error (puede continuar)"

# Paso 3: Configurar proyecto
echo ""
echo "📦 PASO 3/4: Configurando proyecto..."
echo "---------------------------------------------------"

echo "⚠️  IMPORTANTE: Antes de continuar, edita backend/.env con tus credenciales de PostgreSQL"
echo ""
echo "Abre backend/.env y configura:"
echo "  DB_DATABASE=punto_tatto"
echo "  DB_USERNAME=tu_usuario_postgres"
echo "  DB_PASSWORD=tu_password_postgres"
echo ""
read -p "¿Ya configuraste el .env? (s/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[SsYy]$ ]]; then
    echo ""
    echo "Por favor edita backend/.env y ejecuta este script nuevamente."
    echo "O ejecuta: ./configurar-proyecto.sh después de editar .env"
    exit 1
fi

./configurar-proyecto.sh

if [ $? -ne 0 ]; then
    echo ""
    echo "❌ Error en la configuración del proyecto."
    exit 1
fi

# Paso 4: Iniciar proyecto
echo ""
echo "📦 PASO 4/4: ¿Deseas iniciar el proyecto ahora?"
echo "---------------------------------------------------"
read -p "Iniciar servidores? (s/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[SsYy]$ ]]; then
    ./iniciar-proyecto.sh
else
    echo ""
    echo "✅ Instalación completada!"
    echo ""
    echo "Para iniciar el proyecto después, ejecuta:"
    echo "  ./iniciar-proyecto.sh"
    echo ""
    echo "O manualmente:"
    echo "  Terminal 1: cd backend && php artisan serve"
    echo "  Terminal 2: cd frontend && npm run dev"
fi


#!/bin/bash

echo "🚀 Configuración de GitHub para PUNTO TATTO"
echo "============================================"
echo ""

# Verificar si git está instalado
if ! command -v git &> /dev/null; then
    echo "❌ Git no está instalado. Instálalo primero:"
    echo "   brew install git"
    exit 1
fi

# Verificar si ya está inicializado
if [ -d ".git" ]; then
    echo "⚠️  Git ya está inicializado"
    read -p "¿Continuar de todas formas? (s/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[SsYy]$ ]]; then
        exit 0
    fi
fi

# Inicializar git
echo "📦 Inicializando repositorio Git..."
git init

# Agregar archivos
echo "📝 Agregando archivos..."
git add .

# Verificar .env
if git ls-files --error-unmatch backend/.env 2>/dev/null; then
    echo "⚠️  ADVERTENCIA: .env está siendo agregado. ¿Deseas continuar?"
    echo "   (Recomendado: NO subir .env a GitHub)"
    read -p "¿Continuar? (s/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[SsYy]$ ]]; then
        git reset backend/.env
        echo "✅ .env excluido del commit"
    fi
fi

# Commit inicial
echo "💾 Haciendo commit inicial..."
git commit -m "Initial commit: PUNTO TATTO - Plataforma de membresías para artistas de tatuaje

- Backend Laravel con API REST completa
- Frontend Nuxt 3 con paneles de artista, cliente y admin
- Sistema de membresías con 3 planes
- Integración con OpenPay para pagos
- Sistema de ranking automático
- Mensajería interna
- Reseñas y calificaciones"

echo ""
echo "✅ Commit realizado exitosamente!"
echo ""
echo "📋 Próximos pasos:"
echo ""
echo "1. Crea un repositorio en GitHub:"
echo "   Ve a https://github.com/new"
echo "   Crea un nuevo repositorio (NO inicialices con README)"
echo ""
echo "2. Conecta tu repositorio local:"
echo "   git remote add origin https://github.com/TU_USUARIO/punto-tatto.git"
echo "   (Reemplaza TU_USUARIO con tu usuario de GitHub)"
echo ""
echo "3. Sube el código:"
echo "   git branch -M main"
echo "   git push -u origin main"
echo ""
echo "🔐 O usa SSH:"
echo "   git remote add origin git@github.com:TU_USUARIO/punto-tatto.git"
echo "   git push -u origin main"
echo ""

read -p "¿Quieres que te ayude a agregar el remote ahora? (s/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[SsYy]$ ]]; then
    read -p "Ingresa tu usuario de GitHub: " GITHUB_USER
    read -p "Ingresa el nombre del repositorio (default: punto-tatto): " REPO_NAME
    REPO_NAME=${REPO_NAME:-punto-tatto}
    
    echo ""
    echo "Selecciona el método:"
    echo "1) HTTPS (más fácil)"
    echo "2) SSH (más seguro, requiere configuración previa)"
    read -p "Opción (1/2): " METHOD
    
    if [ "$METHOD" == "1" ]; then
        git remote add origin "https://github.com/$GITHUB_USER/$REPO_NAME.git"
        echo "✅ Remote agregado (HTTPS)"
    elif [ "$METHOD" == "2" ]; then
        git remote add origin "git@github.com:$GITHUB_USER/$REPO_NAME.git"
        echo "✅ Remote agregado (SSH)"
    fi
    
    echo ""
    echo "📤 Subiendo código a GitHub..."
    git branch -M main
    git push -u origin main
    
    if [ $? -eq 0 ]; then
        echo ""
        echo "🎉 ¡Proyecto subido exitosamente a GitHub!"
        echo "   https://github.com/$GITHUB_USER/$REPO_NAME"
    else
        echo ""
        echo "❌ Error al subir. Verifica:"
        echo "   - Que el repositorio existe en GitHub"
        echo "   - Que tienes permisos"
        echo "   - Que estás autenticado (git config --global user.name/email)"
    fi
fi


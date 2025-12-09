#!/bin/bash

echo "🔗 Configurar Remote de GitHub"
echo "==============================="
echo ""

# Verificar si ya existe un remote
if git remote get-url origin 2>/dev/null; then
    echo "⚠️  Ya existe un remote 'origin' configurado:"
    git remote get-url origin
    echo ""
    read -p "¿Deseas cambiarlo? (s/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[SsYy]$ ]]; then
        read -p "Ingresa la URL del repositorio (https://github.com/USUARIO/REPO.git): " REPO_URL
        git remote set-url origin "$REPO_URL"
        echo "✅ Remote actualizado"
    else
        echo "Manteniendo remote existente"
        REMOTE_URL=$(git remote get-url origin)
    fi
else
    read -p "Ingresa tu usuario de GitHub: " GITHUB_USER
    read -p "Ingresa el nombre del repositorio (default: punto-tatto): " REPO_NAME
    REPO_NAME=${REPO_NAME:-punto-tatto}
    
    echo ""
    echo "Selecciona el método:"
    echo "1) HTTPS (más fácil, requiere token)"
    echo "2) SSH (más seguro, requiere clave configurada)"
    read -p "Opción (1/2): " METHOD
    
    if [ "$METHOD" == "1" ]; then
        REPO_URL="https://github.com/$GITHUB_USER/$REPO_NAME.git"
    elif [ "$METHOD" == "2" ]; then
        REPO_URL="git@github.com:$GITHUB_USER/$REPO_NAME.git"
    else
        echo "Opción inválida"
        exit 1
    fi
    
    git remote add origin "$REPO_URL"
    echo "✅ Remote agregado: $REPO_URL"
    REMOTE_URL="$REPO_URL"
fi

echo ""
echo "📤 Subiendo código a GitHub..."
echo ""

# Cambiar a branch main
git branch -M main 2>/dev/null || echo "Ya en branch main"

# Intentar push
echo "Ejecutando: git push -u origin main"
git push -u origin main

if [ $? -eq 0 ]; then
    echo ""
    echo "🎉 ¡Proyecto subido exitosamente a GitHub!"
    if [[ "$REMOTE_URL" == *"github.com"* ]]; then
        REPO_URL=${REMOTE_URL%.git}
        REPO_URL=${REPO_URL#git@github.com:}
        REPO_URL=${REPO_URL#https://github.com/}
        echo "   https://github.com/$REPO_URL"
    fi
else
    echo ""
    echo "❌ Error al subir. Posibles causas:"
    echo "   - El repositorio no existe en GitHub"
    echo "   - No tienes permisos"
    echo "   - Problemas de autenticación"
    echo ""
    echo "💡 Soluciones:"
    echo "   1. Verifica que el repositorio existe en GitHub"
    echo "   2. Si usas HTTPS, necesitas un token de acceso"
    echo "   3. Si usas SSH, verifica tu clave SSH"
fi


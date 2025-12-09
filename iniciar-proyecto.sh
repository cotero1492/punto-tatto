#!/bin/bash

echo "🚀 Iniciando PUNTO TATTO"
echo "========================"
echo ""

# Verificar que esté configurado
if [ ! -f "backend/.env" ] || [ ! -d "backend/vendor" ] || [ ! -d "frontend/node_modules" ]; then
    echo "❌ El proyecto no está configurado."
    echo "Ejecuta primero: ./configurar-proyecto.sh"
    exit 1
fi

# Función para limpiar al salir
cleanup() {
    echo ""
    echo "🛑 Deteniendo servidores..."
    kill $BACKEND_PID $FRONTEND_PID 2>/dev/null
    pkill -f "php artisan serve" 2>/dev/null
    pkill -f "nuxt" 2>/dev/null
    exit
}

trap cleanup INT TERM

# Iniciar backend
echo "🔧 Iniciando servidor backend..."
cd backend
php artisan serve > ../backend.log 2>&1 &
BACKEND_PID=$!
cd ..

sleep 2

# Iniciar frontend
echo "🎨 Iniciando servidor frontend..."
cd frontend
npm run dev > ../frontend.log 2>&1 &
FRONTEND_PID=$!
cd ..

sleep 3

echo ""
echo "✅ Servidores iniciados!"
echo ""
echo "📱 Frontend: http://localhost:3000"
echo "🔌 Backend:  http://localhost:8000/api"
echo ""
echo "👤 Admin Login:"
echo "   Email: admin@puntotatto.com"
echo "   Password: admin123"
echo ""
echo "📋 Logs:"
echo "   Backend:  tail -f backend.log"
echo "   Frontend: tail -f frontend.log"
echo ""
echo "⏹️  Presiona Ctrl+C para detener los servidores"
echo ""

# Esperar
wait


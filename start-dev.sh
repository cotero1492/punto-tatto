#!/bin/bash

echo "🚀 Iniciando PUNTO TATTO en modo desarrollo"
echo "==========================================="
echo ""

# Colores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Verificar que las dependencias estén instaladas
if ! command -v php &> /dev/null || ! command -v composer &> /dev/null || ! command -v node &> /dev/null; then
    echo -e "${YELLOW}⚠️  Por favor ejecuta primero: ./install.sh${NC}"
    exit 1
fi

# Verificar .env del backend
if [ ! -f "backend/.env" ]; then
    echo -e "${YELLOW}⚠️  backend/.env no existe. Copiando desde .env.example...${NC}"
    cp backend/.env.example backend/.env
    echo -e "${YELLOW}📝 Por favor configura backend/.env con tus credenciales de base de datos${NC}"
fi

# Iniciar backend en background
echo -e "${GREEN}🔧 Iniciando servidor backend (Laravel)...${NC}"
cd backend
php artisan serve > ../backend.log 2>&1 &
BACKEND_PID=$!
cd ..

# Esperar un poco para que el backend inicie
sleep 3

# Iniciar frontend
echo -e "${GREEN}🎨 Iniciando servidor frontend (Nuxt)...${NC}"
cd frontend
npm run dev > ../frontend.log 2>&1 &
FRONTEND_PID=$!
cd ..

echo ""
echo -e "${GREEN}✅ Servidores iniciados${NC}"
echo ""
echo "📱 Frontend: http://localhost:3000"
echo "🔌 Backend API: http://localhost:8000/api"
echo ""
echo "Logs:"
echo "  - Backend: tail -f backend.log"
echo "  - Frontend: tail -f frontend.log"
echo ""
echo "Para detener los servidores:"
echo "  kill $BACKEND_PID $FRONTEND_PID"
echo ""
echo "O presiona Ctrl+C y ejecuta:"
echo "  pkill -f 'php artisan serve'"
echo "  pkill -f 'npm run dev'"

# Esperar Ctrl+C
trap "echo ''; echo '🛑 Deteniendo servidores...'; kill $BACKEND_PID $FRONTEND_PID 2>/dev/null; exit" INT

wait


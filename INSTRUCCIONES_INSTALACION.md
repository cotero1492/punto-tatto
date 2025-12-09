# 📋 Instrucciones de Instalación - PUNTO TATTO

## 🎯 Opción 1: Instalación Automática (Recomendada)

### Paso 1: Instalar Herramientas

Ejecuta en la terminal (necesitarás tu contraseña de administrador):

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"
./instalar-auto.sh
```

Este script instalará:
- Homebrew (si no lo tienes)
- PHP 8.2+
- Composer
- Node.js 18+
- PostgreSQL

### Paso 2: Configurar Base de Datos

Crea la base de datos PostgreSQL:

```bash
createdb punto_tatto
```

O si tienes un usuario específico:

```bash
createdb -U tu_usuario punto_tatto
```

### Paso 3: Configurar el Proyecto

```bash
./configurar-proyecto.sh
```

Este script:
- Instala dependencias de PHP (Composer)
- Instala dependencias de Node.js (npm)
- Configura el archivo .env
- Ejecuta migraciones
- Crea datos iniciales (seeders)

**⚠️ IMPORTANTE**: Antes de ejecutar, edita `backend/.env` con tus credenciales de PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=punto_tatto
DB_USERNAME=tu_usuario_postgres
DB_PASSWORD=tu_password_postgres
```

### Paso 4: Iniciar el Proyecto

```bash
./iniciar-proyecto.sh
```

O manualmente en dos terminales:

**Terminal 1 - Backend:**
```bash
cd backend
php artisan serve
```

**Terminal 2 - Frontend:**
```bash
cd frontend
npm run dev
```

## 🎯 Opción 2: Instalación Manual

### 1. Instalar Homebrew

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

Sigue las instrucciones en pantalla. Al final, ejecuta los comandos que te indique para agregar Homebrew al PATH.

### 2. Instalar Herramientas

```bash
brew update
brew install php composer node postgresql@14
brew services start postgresql@14
```

### 3. Crear Base de Datos

```bash
createdb punto_tatto
```

### 4. Configurar Backend

```bash
cd backend

# Instalar dependencias
composer install

# Copiar archivo de configuración
cp .env.example .env

# Editar .env con tus credenciales
nano .env  # o usa tu editor favorito

# Generar clave
php artisan key:generate

# Migraciones y seeders
php artisan migrate
php artisan db:seed
```

### 5. Configurar Frontend

```bash
cd frontend

# Instalar dependencias
npm install
```

### 6. Iniciar Servidores

**Backend:**
```bash
cd backend
php artisan serve
```

**Frontend (nueva terminal):**
```bash
cd frontend
npm run dev
```

## ✅ Verificación

Una vez iniciados ambos servidores:

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8000/api

### Login Administrador

- **Email**: `admin@puntotatto.com`
- **Password**: `admin123`

## 🔧 Solución de Problemas

### Error: "Permission denied"
Ejecuta: `chmod +x *.sh`

### Error: "Command not found: brew"
Homebrew no está en el PATH. Ejecuta:
```bash
eval "$(/opt/homebrew/bin/brew shellenv)"
# o
eval "$(/usr/local/bin/brew shellenv)"
```

### Error: "Port already in use"
Cambia los puertos en:
- Backend: `php artisan serve --port=8001`
- Frontend: edita `frontend/nuxt.config.ts`

### Error: "Database connection failed"
Verifica:
1. PostgreSQL está corriendo: `brew services list`
2. Credenciales en `backend/.env` son correctas
3. Base de datos existe: `psql -l | grep punto_tatto`

### Error: "Composer not found"
Agrega al PATH:
```bash
echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

## 📞 Ayuda Adicional

Si tienes problemas, verifica:
1. Todas las herramientas están instaladas: `./verificar-instalacion.sh`
2. Los logs del backend: `tail -f backend.log`
3. Los logs del frontend: `tail -f frontend.log`


# ⚡ Inicio Rápido - PUNTO TATTO

## 🎯 Instalación en 3 Pasos

### 1️⃣ Instalar Herramientas (Una sola vez)

```bash
# Instalar Homebrew (si no lo tienes)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Instalar todas las herramientas necesarias
brew install php composer node postgresql@14

# Iniciar PostgreSQL
brew services start postgresql@14
```

### 2️⃣ Configurar Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate

# Crear base de datos
createdb punto_tatto

# Editar .env y configurar:
# DB_DATABASE=punto_tatto
# DB_USERNAME=tu_usuario_postgres
# DB_PASSWORD=tu_password_postgres

php artisan migrate
php artisan db:seed
php artisan serve
```

### 3️⃣ Configurar Frontend (Nueva Terminal)

```bash
cd frontend
npm install
npm run dev
```

## 🌐 Acceder

- **Frontend**: http://localhost:3000
- **Backend**: http://localhost:8000/api
- **Admin**: admin@puntotatto.com / admin123

## 📝 Todo Listo!

El proyecto está completamente configurado y listo para desarrollo.


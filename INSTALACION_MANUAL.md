# 🔧 Instalación Manual - PUNTO TATTO

Ya que las herramientas no están instaladas automáticamente, aquí tienes la guía paso a paso:

## 📦 Paso 1: Instalar Homebrew (si no lo tienes)

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

**Nota**: Necesitarás ingresar tu contraseña de administrador.

## 📦 Paso 2: Instalar PHP y Composer

```bash
brew install php
brew install composer
```

## 📦 Paso 3: Instalar Node.js

```bash
brew install node
```

## 📦 Paso 4: Instalar PostgreSQL

```bash
brew install postgresql@14
brew services start postgresql@14
```

## 🚀 Paso 5: Configurar el Proyecto

### Backend

```bash
cd backend

# Instalar dependencias PHP
composer install

# Configurar entorno
cp .env.example .env

# Editar .env con tus credenciales de base de datos
# Abre .env y configura:
# DB_DATABASE=punto_tatto
# DB_USERNAME=tu_usuario
# DB_PASSWORD=tu_contraseña

# Generar clave de aplicación
php artisan key:generate

# Crear base de datos
createdb punto_tatto

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (crea planes y usuario admin)
php artisan db:seed

# Iniciar servidor
php artisan serve
```

### Frontend (en otra terminal)

```bash
cd frontend

# Instalar dependencias Node.js
npm install

# Iniciar servidor de desarrollo
npm run dev
```

## ✅ Verificación

Una vez iniciados ambos servidores:

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8000/api

## 🔑 Login Administrador

- Email: `admin@puntotatto.com`
- Password: `admin123`

## ⚠️ Si tienes problemas

1. **Error de permisos**: Asegúrate de tener permisos de administrador
2. **Puerto ocupado**: Cambia los puertos en los comandos
3. **Base de datos**: Verifica que PostgreSQL esté corriendo
4. **Dependencias faltantes**: Ejecuta `composer install` y `npm install` nuevamente


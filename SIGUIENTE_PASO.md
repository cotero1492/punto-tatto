# ✅ Herramientas Instaladas - Siguiente Paso

## 🎯 Ahora configura el proyecto:

### Paso 1: Crear Base de Datos (si no existe)

```bash
createdb punto_tatto
```

O si tienes un usuario específico de PostgreSQL:
```bash
createdb -U tu_usuario punto_tatto
```

### Paso 2: Configurar Backend

```bash
cd backend

# Editar .env con tus credenciales de PostgreSQL
nano .env
# o
open -e .env
```

**Configura estas líneas en .env:**
```env
DB_DATABASE=punto_tatto
DB_USERNAME=tu_usuario_postgres  # Generalmente tu nombre de usuario del sistema
DB_PASSWORD=tu_password_postgres  # Deja vacío si no tienes password
```

### Paso 3: Instalar Dependencias y Configurar

```bash
# Instalar dependencias PHP
composer install

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones (crear tablas)
php artisan migrate

# Ejecutar seeders (datos iniciales)
php artisan db:seed
```

### Paso 4: Configurar Frontend

```bash
cd ../frontend

# Instalar dependencias Node.js
npm install
```

### Paso 5: Iniciar Servidores

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

## 🌐 Acceso

Una vez iniciados ambos servidores:

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8000/api
- **Admin Login**: 
  - Email: `admin@puntotatto.com`
  - Password: `admin123`

## ⚡ O Ejecuta el Script Automático

```bash
./configurar-proyecto.sh
```

Este script hace los pasos 3 y 4 automáticamente (solo necesitas configurar .env primero).

## 🎉 ¡Listo!

El proyecto estará funcionando y podrás verlo en http://localhost:3000


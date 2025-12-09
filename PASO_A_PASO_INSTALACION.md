# 📋 Instalación Paso a Paso - Solución de Problemas

## ⚠️ Si el script automático falla

### Opción A: Script Mejorado

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"
./instalar-manual.sh
```

Este script verifica qué está instalado y solo instala lo que falta.

### Opción B: Instalación Manual Completa

#### Paso 1: Instalar Homebrew

Abre una terminal y ejecuta:

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

**Importante**: 
- Se te pedirá tu contraseña de administrador
- Al finalizar, ejecuta los comandos que aparezcan en pantalla para agregar Homebrew al PATH
- Si aparecen comandos como `eval "$(/opt/homebrew/bin/brew shellenv)"`, cópialos y ejecútalos

**Verificar instalación:**
```bash
brew --version
```

Si dice "command not found", reinicia la terminal o ejecuta:
```bash
eval "$(/opt/homebrew/bin/brew shellenv)"
# o
eval "$(/usr/local/bin/brew shellenv)"
```

#### Paso 2: Actualizar Homebrew

```bash
brew update
```

#### Paso 3: Instalar PHP

```bash
brew install php
```

Verificar:
```bash
php -v
```

#### Paso 4: Instalar Composer

```bash
brew install composer
```

Verificar:
```bash
composer --version
```

#### Paso 5: Instalar Node.js

```bash
brew install node
```

Verificar:
```bash
node --version
npm --version
```

#### Paso 6: Instalar PostgreSQL

```bash
brew install postgresql@14
brew services start postgresql@14
```

Verificar:
```bash
psql --version
```

#### Paso 7: Crear Base de Datos

```bash
createdb punto_tatto
```

Si da error de permisos, prueba:
```bash
createdb -U $(whoami) punto_tatto
```

O si tienes un usuario específico:
```bash
createdb -U tu_usuario punto_tatto
```

## ✅ Verificar Todo

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"
./verificar-instalacion.sh
```

Deberías ver ✅ en todas las herramientas.

## 🔧 Configurar el Proyecto

Una vez que todas las herramientas estén instaladas:

### 1. Editar configuración de base de datos

```bash
nano backend/.env
# o
open -e backend/.env
```

Edita estas líneas:
```env
DB_DATABASE=punto_tatto
DB_USERNAME=tu_usuario_postgres  # Generalmente: $(whoami) o 'postgres'
DB_PASSWORD=tu_password_postgres  # Deja vacío si no tienes password
```

### 2. Configurar Backend

```bash
cd backend
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 3. Configurar Frontend

```bash
cd frontend
npm install
```

### 4. Iniciar Servidores

**Terminal 1:**
```bash
cd backend
php artisan serve
```

**Terminal 2:**
```bash
cd frontend
npm run dev
```

## 🆘 Solución de Problemas Comunes

### Error: "Permission denied"
```bash
sudo chown -R $(whoami) /usr/local
# o para Homebrew en Apple Silicon
sudo chown -R $(whoami) /opt/homebrew
```

### Error: "Command not found: brew"
Agrega al PATH manualmente. Edita `~/.zshrc`:
```bash
nano ~/.zshrc
```

Agrega al final:
```bash
eval "$(/opt/homebrew/bin/brew shellenv)"
```

Luego:
```bash
source ~/.zshrc
```

### Error: "Port already in use"
Backend:
```bash
php artisan serve --port=8001
```

Frontend: Edita `frontend/nuxt.config.ts` y cambia el puerto.

### Error: "Database connection failed"
1. Verifica que PostgreSQL esté corriendo:
   ```bash
   brew services list
   ```

2. Inicia PostgreSQL si no está corriendo:
   ```bash
   brew services start postgresql@14
   ```

3. Verifica tus credenciales en `backend/.env`

### Error: "Composer install fails"
```bash
composer install --ignore-platform-reqs
```

## 📞 Si Nada Funciona

1. Revisa los logs:
   ```bash
   tail -f backend.log
   tail -f frontend.log
   ```

2. Verifica la instalación:
   ```bash
   ./verificar-instalacion.sh
   ```

3. Reinstala Homebrew si es necesario:
   ```bash
   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/uninstall.sh)"
   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
   ```


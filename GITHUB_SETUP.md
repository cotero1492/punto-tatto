# 🚀 Subir Proyecto a GitHub

## 📋 Pasos para subir a GitHub

### 1. Inicializar Git (si no está inicializado)

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"
git init
```

### 2. Agregar todos los archivos

```bash
git add .
```

### 3. Hacer commit inicial

```bash
git commit -m "Initial commit: PUNTO TATTO - Plataforma de membresías para artistas de tatuaje"
```

### 4. Crear repositorio en GitHub

1. Ve a https://github.com
2. Click en el botón **"+"** (esquina superior derecha)
3. Selecciona **"New repository"**
4. Llena los datos:
   - **Repository name**: `punto-tatto` (o el nombre que prefieras)
   - **Description**: "Plataforma de membresías para estudios de tatuaje y artistas"
   - **Visibility**: Público o Privado (tu elección)
   - ⚠️ **NO marques** "Initialize with README" (ya tenemos uno)
5. Click en **"Create repository"**

### 5. Conectar repositorio local con GitHub

GitHub te mostrará comandos, pero aquí están:

```bash
git remote add origin https://github.com/TU_USUARIO/punto-tatto.git
git branch -M main
git push -u origin main
```

**Reemplaza `TU_USUARIO` con tu nombre de usuario de GitHub**

### 6. Subir el código

```bash
git push -u origin main
```

## 🔐 Si usas SSH (recomendado)

Si prefieres usar SSH en lugar de HTTPS:

```bash
git remote add origin git@github.com:TU_USUARIO/punto-tatto.git
git push -u origin main
```

## 📝 Script Automático

Puedes ejecutar el script `setup-github.sh` que hace todo automáticamente:

```bash
./setup-github.sh
```

(Necesitarás ingresar tu nombre de usuario de GitHub)

## ⚠️ Archivos Sensibles

**IMPORTANTE**: Antes de subir, verifica que estos archivos NO se suban:

- `backend/.env` (credenciales de base de datos)
- `frontend/.env` (si existe)
- `node_modules/` (dependencias)
- `vendor/` (dependencias PHP)

Todos estos están en `.gitignore`, pero verifica antes de hacer push.

## ✅ Verificar antes de subir

```bash
# Ver qué archivos se van a subir
git status

# Ver qué está en .gitignore
cat .gitignore
```

## 🔄 Comandos útiles después

```bash
# Agregar cambios
git add .

# Hacer commit
git commit -m "Descripción de los cambios"

# Subir cambios
git push

# Ver estado
git status

# Ver historial
git log
```


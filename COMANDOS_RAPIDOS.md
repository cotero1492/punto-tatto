# ⚡ Comandos Rápidos - PUNTO TATTO

## 🚀 Instalación Completa en un Solo Paso

```bash
cd "/Users/marcocotero/Desktop/PUNTO TATTO 2026"
./EJECUTAR_AHORA.sh
```

Este script hará todo automáticamente (necesitarás ingresar tu contraseña de admin).

## 📋 O Paso a Paso:

### 1. Instalar herramientas (requiere contraseña de admin)
```bash
./instalar-auto.sh
```

### 2. Crear base de datos
```bash
createdb punto_tatto
```

### 3. Editar configuración
```bash
nano backend/.env
# Configura: DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

### 4. Configurar proyecto
```bash
./configurar-proyecto.sh
```

### 5. Iniciar servidores
```bash
./iniciar-proyecto.sh
```

## 🔍 Verificar Instalación

```bash
./verificar-instalacion.sh
```

## 📱 Acceso

- Frontend: http://localhost:3000
- Backend: http://localhost:8000/api
- Admin: admin@puntotatto.com / admin123


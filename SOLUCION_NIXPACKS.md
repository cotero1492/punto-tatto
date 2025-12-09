# ✅ Solución Error Nixpacks

## ❌ Error Original

```
error: undefined variable 'composer'
at /app/.nixpacks/nixpkgs-*.nix:19:9
```

## 🔍 Causa

El archivo `nixpacks.toml` tenía una referencia incorrecta:
```toml
nixPkgs = ["php82", "composer", "php82Packages.composer"]
```

El problema es que `composer` no es un paquete válido en Nix. Solo `php82Packages.composer` es válido.

## ✅ Solución Aplicada

Se simplificó `nixpacks.toml` para dejar que Nixpacks detecte automáticamente PHP y Composer:

```toml
[variables]
PHP_VERSION = "8.2"

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader --no-interaction"]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"
```

## 🚀 Próximos Pasos

1. **Haz push de los cambios:**
   ```bash
   git push
   ```

2. **Railway detectará automáticamente:**
   - PHP 8.2 (por `composer.json` y `PHP_VERSION`)
   - Composer (automático con PHP)
   - Laravel (por `composer.json`)

3. **Alternativa: Si el error persiste**

   **Opción A: Eliminar nixpacks.toml**
   - Nixpacks puede detectar PHP/Composer automáticamente
   - Solo necesitas `composer.json` y `Procfile`

   **Opción B: Usar Dockerfile**
   - Crea un `Dockerfile` en `backend/`
   - Railway usará Docker en lugar de Nixpacks

## 📋 Archivos de Configuración

- ✅ `nixpacks.toml` - Corregido
- ✅ `railway.json` - Configuración de deploy
- ✅ `Procfile` - Comando de inicio
- ✅ `composer.json` - Dependencias PHP

## 🔍 Verificación

Después del push, verifica en Railway:
- ✅ Build completa sin errores de Nix
- ✅ PHP 8.2 detectado correctamente
- ✅ Composer instalado automáticamente
- ✅ Dependencias instaladas correctamente


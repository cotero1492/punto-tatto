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

Se **eliminó** `nixpacks.toml` para dejar que Nixpacks detecte automáticamente PHP y Composer:

**Nixpacks detectará automáticamente:**
- PHP 8.2 (por `composer.json` que requiere `"php": "^8.2"`)
- Composer (automático con PHP)
- Laravel (por `composer.json`)

**Archivos que Railway usará:**
- `composer.json` - Para detectar PHP y dependencias
- `Procfile` o `railway.json` - Para el comando de inicio
- `runtime.txt` - Para especificar versión de PHP (opcional)

## 🚀 Próximos Pasos

1. **Haz push de los cambios:**
   ```bash
   git push
   ```

2. **Railway detectará automáticamente:**
   - PHP 8.2 (por `composer.json` y `PHP_VERSION`)
   - Composer (automático con PHP)
   - Laravel (por `composer.json`)

3. **Si el error persiste**

   **Opción A: Verificar archivos**
   - Asegúrate de tener `composer.json` en `backend/`
   - Asegúrate de tener `Procfile` o `railway.json`

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


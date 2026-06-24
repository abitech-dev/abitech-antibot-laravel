# Instalación

El paquete **Abitech AntiBot Laravel** requiere lo siguiente para funcionar de manera óptima:

- **PHP**: 7.3 hasta 8.3
- **Laravel**: 8.x hasta 13.x

## Opciones de Instalación

Dependiendo de dónde tengas alojado el paquete, elige una de las siguientes opciones:

### Opción A: Desde Packagist (Público)
Si el paquete es público, instálalo ejecutando:
```bash
composer require abitech/antibot-laravel
```

### Opción B: Desde un Repositorio Git (Privado/Público)
Si no está en Packagist, agrega el repositorio al `composer.json` de tu proyecto principal:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/abitech-dev/abitech-antibot-laravel"
    }
]
```
Luego instálalo especificando la rama o el Tag (versión) que deseas utilizar:

**Para una rama específica (Desarrollo):**
```bash
composer require abitech/antibot-laravel:dev-main
```

**Para un Tag / Versión específica (Producción):**
```bash
composer require abitech/antibot-laravel:"^1.0.0"
```

### Opción C: Instalación Local (Para desarrollo)
Si estás desarrollando el paquete en tu máquina y quieres probarlo en otro proyecto Laravel sin subirlo a internet, usa el tipo `path` en el `composer.json` del proyecto principal:
```json
"repositories": [
    {
        "type": "path",
        "url": "../ruta/hacia/abitech-antibot-laravel"
    }
]
```
Y luego instala enlazándolo en modo desarrollo:
```bash
composer require abitech/antibot-laravel:@dev
```

## Pasos Siguientes

1. **Auto-Descubrimiento (Laravel Auto-Discovery):**
   El framework registrará automáticamente el Service Provider (`AntiBotServiceProvider`) y el Facade (`AntiBot`). No es necesario agregar nada manualmente en `config/app.php`.

2. **Publicar Archivos:**
   Es altamente recomendado publicar el archivo de configuración y los mensajes de traducción para personalizarlos según los requisitos de tu aplicación.
   ```bash
   php artisan vendor:publish --tag=antibot-config
   php artisan vendor:publish --tag=antibot-translations
   ```
   - *El archivo de configuración* estará disponible en `config/antibot.php`.
   - *Los archivos de traducción* estarán disponibles en `lang/vendor/antibot/es/` (o dependiendo de tu estructura de Laravel).

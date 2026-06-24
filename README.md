# Abitech AntiBot para Laravel

Una API unificada, limpia y escalable para validar proveedores AntiBot en Laravel. Soporta **Cloudflare Turnstile**, **Google reCAPTCHA v2** y **Google reCAPTCHA v3**.

[![Laravel](https://img.shields.io/badge/Laravel-8.x--13.x-FF2D20.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-7.3--8.3-777BB4.svg)](https://php.net)

---

## 📖 Documentación Oficial

Hemos preparado una documentación estructurada paso a paso para que domines el paquete a profundidad. Por favor, síguela en el siguiente orden:

1. 📦 **[Instalación](docs/1-installation.md)**: Guía sobre cómo agregar el paquete (Packagist, GitHub o Local) y cómo publicar sus recursos.
2. ⚙️ **[Configuración](docs/2-configuration.md)**: Aprende a declarar tus variables de entorno, configurar el proveedor por defecto y ajustar el *score* mínimo.
3. 🚀 **[Uso Básico](docs/3-usage.md)**: Implementación mediante la Regla de Validación (recomendado), Middleware y Facade.
4. 🧠 **[Uso Avanzado](docs/4-advanced.md)**: Cómo utilizar múltiples proveedores al vuelo en un mismo proyecto y validación estricta de acciones (*Action Matching*).

---

## ⚡ Quick Start (Vistazo Rápido)

Si ya tienes experiencia y solo quieres ver cómo funciona, aquí tienes un resumen veloz:

**1. Requerir el paquete:**
```bash
composer require abitech/antibot-laravel:"^1.0.0"
```

**2. Definir tus claves en el archivo `.env`:**
```env
# Proveedor activo (turnstile, recaptcha_v2, recaptcha_v3)
ANTIBOT_DEFAULT=turnstile

# Cloudflare Turnstile
TURNSTILE_SECRET=tu_clave_secreta_aqui

# Google reCAPTCHA v2
# RECAPTCHA_V2_SECRET=tu_clave_secreta_aqui

# Google reCAPTCHA v3
# RECAPTCHA_V3_SECRET=tu_clave_secreta_aqui
# RECAPTCHA_V3_SCORE=0.5
```

**3. Proteger tu formulario (Ejemplo en un Controlador):**
```php
use Abitech\AntiBot\Rules\AntiBotRule;

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        // Valida automáticamente usando el proveedor por defecto y la IP del cliente
        'cf-turnstile-response' => ['required', new AntiBotRule()],
    ]);

    // Lógica de inicio de sesión...
}
```

> **Nota:** Para ver más ejemplos, casos de uso con reCAPTCHA y middleware, dirígete a la sección de **[Uso Básico](docs/3-usage.md)**.

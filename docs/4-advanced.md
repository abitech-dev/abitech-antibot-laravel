# Uso Avanzado

El paquete fue diseñado utilizando el patrón **Manager** de Laravel, lo que permite casos de uso híbridos y avanzados.

## Múltiples Proveedores en un Mismo Proyecto

Si tu aplicación requiere utilizar **Cloudflare Turnstile** en una sección (ej. el Login) y **Google reCAPTCHA v3** invisible en otra (ej. suscripciones a Newsletter), puedes lograrlo fácilmente al vuelo sin alterar el proveedor por defecto.

Utiliza el método `driver()` del Facade para indicar qué servicio instanciar temporalmente:

```php
use Abitech\AntiBot\Facades\AntiBot;

// 1. Usar reCAPTCHA v2 en este controlador:
$resultV2 = AntiBot::driver('recaptcha_v2')->verify($token);

// 2. Usar Cloudflare Turnstile en otro lado:
$resultTurnstile = AntiBot::driver('turnstile')->verify($token);
```

## Validación de Acciones (Action Matching)

Tanto **Google reCAPTCHA v3** como **Cloudflare Turnstile** permiten adjuntar un identificador de "acción" al token generado en el Front-end. El paquete te permite verificar que esta acción coincida exactamente con la esperada en el Back-end.

**En la Regla de Validación:**
```php
new AntiBotRule('login_action')
```

**En el Middleware:**
```php
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('antibot:login_action');
```

**Con el Facade:**
```php
// Firma: verify(string $token, ?string $ip = null, ?string $action = null)
$result = AntiBot::verify($token, $request->ip(), 'login_action');
```

Si el nombre de la acción devuelta por el servidor de Google o Cloudflare difiere de la esperada, la validación fallará garantizando mayor protección contra *replay attacks*.

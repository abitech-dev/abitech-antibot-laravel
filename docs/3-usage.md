# Uso

El paquete provee tres mecanismos principales para validar los tokens que envían tus clientes (Frontend).

## 1. Regla de Validación (Validation Rule)

Es el método más idiomático y recomendado en Laravel. Puedes integrar `AntiBotRule` directamente en un `FormRequest` o dentro de un controlador.

```php
use Abitech\AntiBot\Rules\AntiBotRule;

public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        // 'g-recaptcha-response' o 'cf-turnstile-response'
        'cf-turnstile-response' => ['required', new AntiBotRule()],
    ]);
}
```

*Nota: La regla maneja internamente la dirección IP del usuario para agregar mayor precisión a la verificación.*

## 2. Middleware

Puedes proteger rutas completas o grupos de rutas. El middleware buscará el token en el Header `X-AntiBot-Token` o en la variable de payload `antibot_token`.

```php
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('antibot');
```

En caso de fallo, el middleware abortará la solicitud devolviendo un código `HTTP 403 Forbidden` con el mensaje de error traducido.

## 3. Uso del Facade

Si requieres control absoluto del flujo, puedes validar el token manualmente en cualquier parte de la aplicación.

```php
use Abitech\AntiBot\Facades\AntiBot;

$token = $request->input('g-recaptcha-response');
$result = AntiBot::verify($token);

if ($result->success) {
    // Procesar la solicitud
} else {
    // Manejar el error localmente
    // $errores = $result->errors;
}
```

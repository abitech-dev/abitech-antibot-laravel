# Plan de implementacion del paquete

## Fase 1 - Base del paquete

- Crear paquete Composer `abitech/antibot-laravel`.
- Configurar PSR-4 apuntando a `src/`.
- Crear Service Provider (`AntiBotServiceProvider`).
- Crear Facade (`AntiBot`).
- Crear archivo de configuración `config/antibot.php`.
- Configurar la publicación de archivos de configuración y traducciones (`lang/es/validation.php`).

---

## Fase 2 - Arquitectura base

Crear:

- `Contracts/AntiBotProviderInterface.php`
- `DTOs/VerificationResult.php`
- `AntiBotManager.php` (Extenderá de `Illuminate\Support\Manager`)
- Excepciones personalizadas en `Exceptions/` (e.g. `AntiBotException`).

Objetivo:

- Centralizar la validación.
- Permitir múltiples proveedores usando el patrón Manager de Laravel.
- Firma estandarizada: `verify(string $token, ?string $ip = null, ?string $action = null): VerificationResult`

---

## Fase 3 - Cloudflare Turnstile

Crear:

- `Providers/CloudflareTurnstileProvider.php`

Implementar:

- Validación de token usando el Facade `Http` de Laravel.
- Soporte opcional para validar `remoteip` e `action`.
- Manejo de errores y conversiones a `VerificationResult`.

Crear pruebas unitarias con `Http::fake()`.

---

## Fase 4 - Google reCAPTCHA v2

Crear:

- `Providers/GoogleRecaptchaV2Provider.php`

Implementar:

- Verificación mediante API oficial usando `Http`.
- Soporte opcional para validar `remoteip`.
- Conversión a `VerificationResult`.

Crear pruebas unitarias.

---

## Fase 5 - Google reCAPTCHA v3

Crear:

- `Providers/GoogleRecaptchaV3Provider.php`

Implementar:

- Validación mediante API oficial.
- Soporte para validar `action` (extremadamente importante en v3) y `remoteip`.
- Validación de score mínimo desde configuración (`config('antibot.recaptcha_v3.score')`).
- Conversión a `VerificationResult`.

Crear pruebas unitarias.

---

## Fase 6 - Registro de proveedores

Configurar resolución automática en `AntiBotManager` leyendo:

`config('antibot.default')`

Proveedores soportados:

- `turnstile`
- `recaptcha_v2`
- `recaptcha_v3`

---

## Fase 7 - API pública

Crear o refinar Facade en `Facades/AntiBot.php`:

Uso esperado:
`AntiBot::verify(string $token, ?string $ip = null, ?string $action = null)`

---

## Fase 8 - Validation Rule

Crear:

- `Rules/AntiBotRule.php`

Uso esperado:

`new AntiBotRule(?string $action = null)` (Permitir definir la acción a validar opcionalmente)

---

## Fase 9 - Middleware

Crear:

- `Middleware/VerifyAntiBotMiddleware.php`

Uso esperado:

`->middleware('antibot:action')` (Donde action es opcional)

---

## Fase 10 - Documentación

Crear README.md.

Documentar:

- Instalación
- Configuración
- Cloudflare Turnstile
- Google reCAPTCHA v2
- Google reCAPTCHA v3
- Validation Rule y Middleware
- Facade

---

## Versión 1.0.0

Incluye:

- Manager de Laravel
- Cloudflare Turnstile
- Google reCAPTCHA v2
- Google reCAPTCHA v3
- Facade
- Validation Rule
- Middleware
- Soporte Multi-idioma (lang)
- Tests (`Http::fake()`)
- Documentación

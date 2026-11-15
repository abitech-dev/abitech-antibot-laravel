<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset=".github/assets/logo-dark.svg">
    <img alt="AntiBot para Laravel" src=".github/assets/logo-light.svg" width="420">
  </picture>
</p>

<h3 align="center">Protege tus formularios de bots con una sola regla de validación</h3>

<p align="center">
  <a href="https://packagist.org/packages/abitech/antibot-laravel"><img alt="Versión en Packagist" src="https://img.shields.io/packagist/v/abitech/antibot-laravel?style=flat-square&color=1c6ccc&label=packagist"></a>
  <a href="https://packagist.org/packages/abitech/antibot-laravel"><img alt="Descargas" src="https://img.shields.io/packagist/dt/abitech/antibot-laravel?style=flat-square&color=1c6ccc&label=descargas"></a>
  <a href="https://github.com/abitech-dev/abitech-antibot-laravel/actions/workflows/ci.yml"><img alt="Integración continua" src="https://img.shields.io/github/actions/workflow/status/abitech-dev/abitech-antibot-laravel/ci.yml?branch=main&style=flat-square&label=CI"></a>
  <img alt="PHP 7.3 o superior" src="https://img.shields.io/badge/php-%E2%89%A57.3-777bb4?style=flat-square&logo=php&logoColor=white">
  <img alt="Laravel 8 a 13" src="https://img.shields.io/badge/laravel-8%20a%2013-ff2d20?style=flat-square&logo=laravel&logoColor=white">
  <a href="LICENSE"><img alt="Licencia MIT" src="https://img.shields.io/badge/licencia-MIT-2ea043?style=flat-square"></a>
</p>

<p align="center">
  <a href="#inicio-rápido">Inicio rápido</a> &nbsp;|&nbsp;
  <a href="#uso">Uso</a> &nbsp;|&nbsp;
  <a href="#configuración">Configuración</a> &nbsp;|&nbsp;
  <a href="#en-las-pruebas">En las pruebas</a> &nbsp;|&nbsp;
  <a href="README.en.md">English</a>
</p>

<br>

Los formularios públicos, como el registro, el inicio de sesión o el de
contacto, reciben envíos automáticos de bots. **AntiBot** valida en el
servidor el token que generan Cloudflare Turnstile o Google reCAPTCHA, con la
misma regla para los tres proveedores. Cambiar de uno a otro es cambiar una
variable de entorno.

<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset=".github/assets/flujo-dark.svg">
    <img alt="El formulario envía el token, AntiBotRule lo verifica con el proveedor, y la solicitud sigue al controlador o se rechaza con 422 o 403" src=".github/assets/flujo-light.svg" width="860">
  </picture>
</p>

## Inicio rápido

**1. Instala el paquete.** Laravel lo registra solo.

```bash
composer require abitech/antibot-laravel
```

**2. Agrega la clave secreta** de tu proveedor al `.env`.

```env
ANTIBOT_DEFAULT=turnstile
TURNSTILE_SECRET=tu-clave-secreta
```

**3. Valida el formulario** con la regla.

```php
use Abitech\AntiBot\Rules\AntiBotRule;

$request->validate([
    'email' => ['required', 'email'],
    'cf-turnstile-response' => ['required', new AntiBotRule()],
]);
```

Listo. Si el token no es válido, Laravel devuelve el error de validación como
con cualquier otra regla.

## Características

<table>
  <tr>
    <td width="50%" valign="top">
      <h4>🛡️ Una sola API</h4>
      Turnstile, reCAPTCHA v2 y reCAPTCHA v3 se validan igual, con
      <code>new AntiBotRule()</code>.
    </td>
    <td width="50%" valign="top">
      <h4>🧩 Regla, middleware o fachada</h4>
      Se usa donde encaja mejor, sin repetir código en cada formulario.
    </td>
  </tr>
  <tr>
    <td valign="top">
      <h4>🎯 Acción y puntaje</h4>
      Comprueba que la acción del token sea la esperada y que reCAPTCHA v3
      pase el puntaje mínimo.
    </td>
    <td valign="top">
      <h4>🧪 Fácil de probar</h4>
      <code>ANTIBOT_ENABLED=false</code> apaga la verificación en local y en
      las pruebas automatizadas.
    </td>
  </tr>
  <tr>
    <td valign="top">
      <h4>💬 Mensajes en español</h4>
      Los errores llegan traducidos y se pueden cambiar publicando sus
      textos.
    </td>
    <td valign="top">
      <h4>✅ Probado de Laravel 8 a 13</h4>
      La integración continua corre las pruebas en cada versión, con su PHP
      mínimo.
    </td>
  </tr>
</table>

## Proveedores

| Proveedor | `ANTIBOT_DEFAULT` | Comprueba |
| --- | --- | --- |
| <img alt="" src="https://img.shields.io/badge/-Cloudflare%20Turnstile-f38020?style=flat-square&logo=cloudflare&logoColor=white"> | `turnstile` | Token y acción |
| <img alt="" src="https://img.shields.io/badge/-reCAPTCHA%20v2-4285f4?style=flat-square&logo=google&logoColor=white"> | `recaptcha_v2` | Token |
| <img alt="" src="https://img.shields.io/badge/-reCAPTCHA%20v3-4285f4?style=flat-square&logo=google&logoColor=white"> | `recaptcha_v3` | Token, acción y puntaje |

## Compatibilidad

| Laravel | PHP mínimo | Estado |
| --- | --- | --- |
| 13 | 8.3 | ✅ Probado |
| 12 | 8.2 | ✅ Probado |
| 11 | 8.2 | ✅ Probado |
| 10 | 8.1 | ✅ Probado |
| 9 | 8.0 | ✅ Probado |
| 8 | 7.3 | ✅ Probado |

## Uso

### Con la regla de validación

Es la forma recomendada. Valida el token junto con la IP de quien envía el
formulario. Con reCAPTCHA el campo se llama `g-recaptcha-response`.

```php
'g-recaptcha-response' => ['required', new AntiBotRule()],
```

### Con el middleware

Protege una ruta completa. Lee el token de la cabecera `X-AntiBot-Token` o del
campo `antibot_token`, y responde 403 si no es válido.

```php
Route::post('/contacto', ContactoController::class)->middleware('antibot');
```

### Con la fachada

Para decidir en el código qué hacer con el resultado.

```php
use Abitech\AntiBot\Facades\AntiBot;

$resultado = AntiBot::verify($token, $request->ip());

if (! $resultado->success) {
    // $resultado->errors trae los códigos de error del proveedor.
}
```

<details>
<summary><strong>Exigir una acción</strong></summary>
<br>

Turnstile y reCAPTCHA v3 adjuntan al token el nombre de la acción. Si no
coincide con la esperada, la validación falla. Así un token generado en otro
formulario no sirve en este.

```php
new AntiBotRule('login');                               // En la regla
Route::post('/login', ...)->middleware('antibot:login'); // En el middleware
AntiBot::verify($token, $request->ip(), 'login');       // Con la fachada
```

</details>

<details>
<summary><strong>Usar otro proveedor en una sola parte</strong></summary>
<br>

El proveedor por defecto sale de `ANTIBOT_DEFAULT`. Para usar otro en un lugar
concreto, pídelo por su nombre.

```php
AntiBot::driver('recaptcha_v3')->verify($token, $request->ip(), 'suscripcion');
```

</details>

## Configuración

Todo se configura con variables de entorno.

| Variable | Por defecto | Para qué sirve |
| --- | --- | --- |
| `ANTIBOT_ENABLED` | `true` | `false` aprueba todo sin consultar al proveedor |
| `ANTIBOT_DEFAULT` | `turnstile` | Proveedor de la regla y el middleware |
| `TURNSTILE_SECRET` | | Clave secreta de Cloudflare Turnstile |
| `RECAPTCHA_V2_SECRET` | | Clave secreta de reCAPTCHA v2 |
| `RECAPTCHA_V3_SECRET` | | Clave secreta de reCAPTCHA v3 |
| `RECAPTCHA_V3_SCORE` | `0.5` | Puntaje mínimo de reCAPTCHA v3, de 0 a 1 |

Cada proveedor acepta también su `*_TIMEOUT`, en segundos (10 por defecto).
Para cambiar algo más, publica el archivo de configuración o los mensajes:

```bash
php artisan vendor:publish --tag=antibot-config
php artisan vendor:publish --tag=antibot-translations
```

## En las pruebas

Apaga la verificación en `phpunit.xml` para que las pruebas no dependan de
internet.

```xml
<env name="ANTIBOT_ENABLED" value="false"/>
```

Para probar el rechazo, deja el paquete encendido y simula la respuesta del
proveedor con `Http::fake()`.

## Más información

- 📚 [Guía completa](docs/1-installation.md), con la configuración y el uso
  avanzado.
- 🔒 [Política de seguridad](SECURITY.md). Las vulnerabilidades se reportan en
  privado.
- 🤝 [Guía para contribuir](CONTRIBUTING.md). Las propuestas son bienvenidas.
- 📝 [Cambios de cada versión](CHANGELOG.md).

## Licencia

Publicado con la [licencia MIT](LICENSE). Puedes usarlo, modificarlo y
distribuirlo, también en proyectos comerciales.

<br>

<p align="center">
  Hecho en Huánuco, Perú, por <a href="https://abitech.dev">Abimael Fernandez</a>
</p>

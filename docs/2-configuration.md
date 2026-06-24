# Configuración

Una vez publicado el archivo de configuración (`config/antibot.php`), podrás gestionar todos los proveedores desde tu archivo `.env`.

## Proveedor por Defecto

Define cuál de los servicios AntiBot se utilizará de manera global en tu aplicación. Los valores aceptados son:
- `turnstile` (Cloudflare)
- `recaptcha_v2` (Google)
- `recaptcha_v3` (Google)

```env
ANTIBOT_DEFAULT=turnstile
```

## Credenciales de Proveedores

Añade las siguientes variables a tu `.env` dependiendo del servicio que vayas a utilizar:

### Cloudflare Turnstile
```env
TURNSTILE_SECRET=tu_clave_secreta_aqui
```

### Google reCAPTCHA v2
```env
RECAPTCHA_V2_SECRET=tu_clave_secreta_aqui
```

### Google reCAPTCHA v3
Para la versión 3, adicional a la clave secreta, puedes definir un `score` (puntuación mínima) de tolerancia. El puntaje oscila entre `0.0` (muy probable que sea un bot) y `1.0` (muy probable que sea humano).

```env
RECAPTCHA_V3_SECRET=tu_clave_secreta_aqui
RECAPTCHA_V3_SCORE=0.5
```

## Configuración Avanzada

Si abres el archivo `config/antibot.php`, encontrarás opciones de personalización como:
- **Tiempos de espera (Timeout):** Permite controlar el tiempo máximo de espera para las peticiones HTTP a las APIs externas.
- **URLs de las APIs:** Direcciones predeterminadas de los servicios.

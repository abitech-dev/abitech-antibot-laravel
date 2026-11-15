# Cambios

Todos los cambios de este paquete se anotan aquí. El formato sigue
[Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/) y las versiones,
[Semantic Versioning](https://semver.org/lang/es/).

## 1.0.0 (2026-06-24)

### Agregado

- Validación de Cloudflare Turnstile, Google reCAPTCHA v2 y reCAPTCHA v3 con
  una sola API.
- Regla `AntiBotRule`, middleware `antibot` y fachada `AntiBot`.
- Comprobación de la acción del token y del puntaje mínimo de reCAPTCHA v3.
- Variable `ANTIBOT_ENABLED` para apagar la verificación en las pruebas.
- Mensajes de error en español.

### Corregido

- `AntiBotRule` implementa la interfaz `Rule` de Laravel.

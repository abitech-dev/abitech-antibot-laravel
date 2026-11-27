# CLAUDE.md

## 1. Proyecto

**abitechdev/antibot-laravel.** Paquete Composer que protege los
formularios de Laravel contra bots con Cloudflare Turnstile o Google
reCAPTCHA v2 y v3, desde una regla de validación (`AntiBotRule`) o un
middleware (`VerifyAntiBotMiddleware`).

- Genérico de Abitech y público en Packagist, con licencia MIT.
- Soporta PHP 7.3 o superior y Laravel 8 a 13, en un solo rango de
  `composer.json`.
- Idioma (excepción de `core/04` regla 3). Clases, métodos y variables en
  inglés; mensajes, traducciones de `lang/es`, docs y commits en español.

## 2. Comandos

```bash
composer install
composer test                          # PHPUnit con Orchestra Testbench
vendor/bin/phpunit --filter ProvidersTest
composer validate --strict
composer audit
```

Pint y Larastan no están en `composer.json`, porque piden PHP 8 y el
paquete promete PHP 7.3. Para correrlos en local se instalan sin guardar:

```bash
composer require --dev -W laravel/pint:^1 larastan/larastan:^3
vendor/bin/pint --test
vendor/bin/phpstan analyse --no-progress
git checkout composer.json
```

## 3. Puertas de calidad

La CI (`.github/workflows/ci.yml`) corre en cada PR y en cada push a
`main`.

- **Paquete.** Valida `composer.json` y la sección `[Sin publicar]` del
  CHANGELOG, busca secretos con gitleaks, audita las dependencias y revisa
  que el archivo que descarga Composer no lleve pruebas, `docs/` ni
  `.claude/`.
- **Estático.** Pint con PSR-12 y PHPStan nivel 6 con Larastan.
- **Pruebas.** PHPUnit con cada Laravel prometido y su PHP mínimo, de PHP
  7.3 con Laravel 8 a PHP 8.5 con Laravel 13.

Antes de entregar, las tres sin errores.

## 4. Lo que sorprende

1. **`composer.lock` y `vendor/` no se versionan.** Cada app host resuelve
   sus versiones dentro de los rangos de `composer.json`.
2. **La CI desactiva el bloqueo de avisos de Composer en las pruebas.**
   Laravel 8 a 11 tienen avisos sin parche, y el paquete los sigue
   soportando.
3. **La etiqueta `1.0.0` no lleva `v`.** Es la primera versión publicada y
   no se vuelve a etiquetar; desde la `v1.0.1` todas llevan `v`.

## 5. Configuración de Claude Code

Dónde va cada pieza, `core/06`; cómo se escribe, `core/08`. Proyecto en
**modo compartido**. `CLAUDE.md` y `.claude/` se versionan aquí, y su
versión vive en el repositorio privado `abitech-dev/_claude`, con el
`stack` declarado en su `claude-sync.json`.

- `rules/core/`, `agents/`, `hooks/*.py` y las skills son copia de la base
  global. Se editan en `~/.claude` y llegan con `sync.py guardar global` y
  luego `sync.py restaurar abitech-antibot-laravel`.
- `tech/laravel-package.md` es la misma de los demás paquetes Composer.
- Una buena práctica que convenga fijar se propone como cambio en su
  regla; nunca se aplica en silencio.

## 6. Despliegue

Un paquete no se despliega; se publica según `tech/laravel-package.md`
regla 7 y el ADR 0001. Al unir a `main` el PR que fecha la versión,
`release.yml` crea la etiqueta y Packagist la publica. El push pide
confirmación (`settings.json`).

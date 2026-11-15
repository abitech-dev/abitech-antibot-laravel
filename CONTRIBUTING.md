# Contribuir

Gracias por querer mejorar el paquete. Esta guía resume lo que revisa la
integración continua, para que tu PR pase a la primera.

## Preparar el entorno

```bash
git clone https://github.com/abitech-dev/abitech-antibot-laravel.git
cd abitech-antibot-laravel
composer install
composer test
```

## Antes de abrir el PR

- Cada cambio de comportamiento lleva su prueba en `tests/`.
- El estilo sigue PSR-12 y se revisa con Laravel Pint (`pint.json`).
- El análisis estático pasa en el nivel 6 de PHPStan, con Larastan
  (`phpstan.neon.dist`).
- El código sigue funcionando en PHP 7.3, porque el paquete lo promete.

Pint y Larastan piden PHP 8, así que no están en `composer.json`. Para
correrlos en tu equipo:

```bash
composer require --dev laravel/pint larastan/larastan
vendor/bin/pint --test
vendor/bin/phpstan analyse
```

No subas esos cambios de `composer.json`.

## Mensajes de commit

Se usan [Conventional Commits](https://www.conventionalcommits.org/es/v1.0.0/),
como `feat(core): aceptar hCaptcha` o `fix(rule): leer la IP detrás de un proxy`.

Cada cambio que nota quien usa el paquete suma su línea en la sección
`[Sin publicar]` del `CHANGELOG.md`, en el mismo PR.

## Publicación

Las versiones siguen [SemVer](https://semver.org/lang/es/). Un `fix` sube el
parche, un `feat` la menor y un cambio incompatible la mayor.

1. Un PR cambia `## [Sin publicar]` por la versión con su fecha, por ejemplo
   `## [1.1.0] - 2026-12-01`, y deja arriba una sección `[Sin publicar]`
   vacía.
2. Al unirlo, la Action crea la etiqueta `v1.1.0` y el release de GitHub con
   esas notas.
3. Packagist publica la etiqueta sola.

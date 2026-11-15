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

Se usan [Conventional Commits](https://www.conventionalcommits.org/es/v1.0.0/).
Con ellos se calcula la versión siguiente y se escribe el CHANGELOG.

| Tipo                                      | Cuándo                       | Versión |
| ----------------------------------------- | ---------------------------- | ------- |
| `feat`                                    | Algo nuevo para quien lo usa | Menor   |
| `fix`                                     | Corrige un fallo             | Parche  |
| `feat!` o `fix!`                          | Rompe la compatibilidad      | Mayor   |
| `docs`, `test`, `ci`, `chore`, `refactor` | No cambia el uso             | Ninguna |

## Publicación

Nadie publica a mano. Al unir a `main`, la integración continua abre o
actualiza el PR de la versión siguiente. Al unir ese PR se crea la etiqueta, y
Packagist la publica.

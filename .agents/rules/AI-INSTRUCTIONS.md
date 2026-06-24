# AI_INSTRUCTIONS.md

## Proyecto

Paquete Composer:

abitech/antibot-laravel

Objetivo:

Proporcionar una API unificada para validar proveedores AntiBot en Laravel.

Proveedores iniciales:

- Google reCAPTCHA v2
- Google reCAPTCHA v3
- Cloudflare Turnstile

---

## Reglas

### Arquitectura

- Aplicar SOLID.
- Mantener bajo acoplamiento.
- Utilizar Strategy Pattern para los proveedores, administrados a través de `Illuminate\Support\Manager` de Laravel.
- Cada proveedor debe implementar una interfaz común (`AntiBotProviderInterface`).
- La interfaz de validación principal debe soportar obligatoriamente la estructura: `verify(string $token, ?string $ip = null, ?string $action = null)`.

### Código

- Usar `declare(strict_types=1);`
- Cumplir PSR-12.
- Tipar parámetros, propiedades y retornos.
- No usar FQN en línea; importar con `use`.
- Evitar duplicación de código.
- Priorizar soluciones simples y mantenibles.
- Utilizar el Facade `Http` de Laravel para las peticiones externas.

### Estructura

Organizar en:

- Contracts
- Providers
- Exceptions
- Facades
- DTOs
- Rules
- Middleware
- Tests
- lang/es (para traducciones publicables de validación)

### DTOs

- No retornar arrays mágicos.
- Utilizar DTOs (`VerificationResult`) para respuestas de validación.

### Configuración

Toda configuración debe estar en:

config/antibot.php

No hardcodear:

- URLs
- API Keys
- Scores
- Timeouts

### Comentarios y mensajes

- Todos los comentarios deben estar en español.
- Todos los mensajes de error/validación deben estar en español (preferiblemente usando lang files).
- Los comentarios deben ser breves y aportar valor.
- No agregar comentarios obvios o redundantes.
- No documentar línea por línea.
- Comentar únicamente lógica compleja o decisiones importantes.

Incorrecto:

```php
// Asignar el token a la variable token
$token = $request->input('token');
```

Correcto:

```php
// Validar score mínimo requerido por el proveedor.
```

### Testing

- Crear pruebas para cada nueva funcionalidad.
- Utilizar `Http::fake()` para simular llamadas externas a los proveedores.

### Extensibilidad

- Debe ser posible agregar nuevos proveedores sin modificar la lógica existente (Aprovechando `extend` de `Manager`).
- Cumplir Open/Closed Principle.

---

## Prioridades

1. Simplicidad.
2. Legibilidad.
3. Mantenibilidad.
4. Extensibilidad.
5. Testing.

Evitar sobreingeniería.
Evitar abstracciones innecesarias.
Evitar código que no aporte valor al proyecto.

<?php

declare(strict_types=1);

namespace Abitech\AntiBot\Contracts;

use Abitech\AntiBot\DTOs\VerificationResult;

interface AntiBotProviderInterface
{
    /**
     * Verifica el token enviado por el usuario.
     *
     * @param string $token Token de respuesta del cliente.
     * @param string|null $ip Dirección IP del cliente (opcional).
     * @param string|null $action Acción esperada (opcional, para reCAPTCHA v3 / Turnstile).
     * @return VerificationResult
     */
    public function verify(string $token, ?string $ip = null, ?string $action = null): VerificationResult;
}

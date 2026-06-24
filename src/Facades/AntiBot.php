<?php

declare(strict_types=1);

namespace Abitech\AntiBot\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Abitech\AntiBot\DTOs\VerificationResult verify(string $token, ?string $ip = null, ?string $action = null)
 *
 * @see \Abitech\AntiBot\AntiBotManager
 * @see \Abitech\AntiBot\Contracts\AntiBotProviderInterface
 */
class AntiBot extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'antibot';
    }
}

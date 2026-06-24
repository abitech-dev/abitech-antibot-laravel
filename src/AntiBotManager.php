<?php

declare(strict_types=1);

namespace Abitech\AntiBot;

use Illuminate\Support\Manager;
use Abitech\AntiBot\Contracts\AntiBotProviderInterface;
use Abitech\AntiBot\Providers\CloudflareTurnstileProvider;
use Abitech\AntiBot\Providers\GoogleRecaptchaV2Provider;
use Abitech\AntiBot\Providers\GoogleRecaptchaV3Provider;

class AntiBotManager extends Manager
{
    /**
     * Obtener el nombre del driver por defecto.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('antibot.default', 'turnstile');
    }

    /**
     * Crear el driver para Cloudflare Turnstile.
     *
     * @return AntiBotProviderInterface
     */
    protected function createTurnstileDriver(): AntiBotProviderInterface
    {
        return new CloudflareTurnstileProvider(
            $this->config->get('antibot.providers.turnstile.url', 'https://challenges.cloudflare.com/turnstile/v0/siteverify'),
            $this->config->get('antibot.providers.turnstile.secret', ''),
            (int) $this->config->get('antibot.providers.turnstile.timeout', 10)
        );
    }

    /**
     * Crear el driver para Google reCAPTCHA v2.
     *
     * @return AntiBotProviderInterface
     */
    protected function createRecaptchaV2Driver(): AntiBotProviderInterface
    {
        return new GoogleRecaptchaV2Provider(
            $this->config->get('antibot.providers.recaptcha_v2.url', 'https://www.google.com/recaptcha/api/siteverify'),
            $this->config->get('antibot.providers.recaptcha_v2.secret', ''),
            (int) $this->config->get('antibot.providers.recaptcha_v2.timeout', 10)
        );
    }

    /**
     * Crear el driver para Google reCAPTCHA v3.
     *
     * @return AntiBotProviderInterface
     */
    protected function createRecaptchaV3Driver(): AntiBotProviderInterface
    {
        return new GoogleRecaptchaV3Provider(
            $this->config->get('antibot.providers.recaptcha_v3.url', 'https://www.google.com/recaptcha/api/siteverify'),
            $this->config->get('antibot.providers.recaptcha_v3.secret', ''),
            (float) $this->config->get('antibot.providers.recaptcha_v3.score', 0.5),
            (int) $this->config->get('antibot.providers.recaptcha_v3.timeout', 10)
        );
    }
}

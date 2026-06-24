<?php

declare(strict_types=1);

namespace Abitech\AntiBot\Providers;

use Abitech\AntiBot\Contracts\AntiBotProviderInterface;
use Abitech\AntiBot\DTOs\VerificationResult;
use Abitech\AntiBot\Exceptions\AntiBotException;
use Illuminate\Support\Facades\Http;

class GoogleRecaptchaV2Provider implements AntiBotProviderInterface
{
    /** @var string */
    protected $url;

    /** @var string */
    protected $secret;

    /** @var int */
    protected $timeout;

    public function __construct(string $url, string $secret, int $timeout = 10)
    {
        $this->url = $url;
        $this->secret = $secret;
        $this->timeout = $timeout;
    }

    public function verify(string $token, ?string $ip = null, ?string $action = null): VerificationResult
    {
        if (empty($this->secret)) {
            throw new AntiBotException(trans('antibot::messages.recaptcha_v2_secret_missing'));
        }

        $response = Http::timeout($this->timeout)->asForm()->post($this->url, [
            'secret' => $this->secret,
            'response' => $token,
            'remoteip' => $ip,
        ]);

        if ($response->failed()) {
            throw new AntiBotException(trans('antibot::messages.recaptcha_v2_api_error'));
        }

        $data = $response->json();

        return new VerificationResult(
            $data['success'] ?? false,
            null,
            $data['error-codes'] ?? []
        );
    }
}

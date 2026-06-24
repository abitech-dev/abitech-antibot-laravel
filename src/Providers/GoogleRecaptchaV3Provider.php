<?php

declare(strict_types=1);

namespace Abitech\AntiBot\Providers;

use Abitech\AntiBot\Contracts\AntiBotProviderInterface;
use Abitech\AntiBot\DTOs\VerificationResult;
use Abitech\AntiBot\Exceptions\AntiBotException;
use Illuminate\Support\Facades\Http;

class GoogleRecaptchaV3Provider implements AntiBotProviderInterface
{
    /** @var string */
    protected $url;

    /** @var string */
    protected $secret;

    /** @var float */
    protected $minScore;

    /** @var int */
    protected $timeout;

    public function __construct(string $url, string $secret, float $minScore = 0.5, int $timeout = 10)
    {
        $this->url = $url;
        $this->secret = $secret;
        $this->minScore = $minScore;
        $this->timeout = $timeout;
    }

    public function verify(string $token, ?string $ip = null, ?string $action = null): VerificationResult
    {
        if (empty($this->secret)) {
            throw new AntiBotException(trans('antibot::messages.recaptcha_v3_secret_missing'));
        }

        $response = Http::timeout($this->timeout)->asForm()->post($this->url, [
            'secret' => $this->secret,
            'response' => $token,
            'remoteip' => $ip,
        ]);

        if ($response->failed()) {
            throw new AntiBotException(trans('antibot::messages.recaptcha_v3_api_error'));
        }

        $data = $response->json();

        $success = $data['success'] ?? false;
        $errors = $data['error-codes'] ?? [];
        $score = isset($data['score']) ? (float) $data['score'] : null;
        $responseAction = $data['action'] ?? null;

        if ($success) {
            if ($score !== null && $score < $this->minScore) {
                $success = false;
                $errors[] = 'score-too-low';
            }

            if ($action !== null && $responseAction !== $action) {
                $success = false;
                $errors[] = 'action-mismatch';
            }
        }

        return new VerificationResult(
            $success,
            $score,
            $errors,
            $responseAction
        );
    }
}

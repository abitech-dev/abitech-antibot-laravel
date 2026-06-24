<?php

namespace Abitech\AntiBot\Tests\Feature;

use Abitech\AntiBot\Tests\TestCase;
use Abitech\AntiBot\Facades\AntiBot;
use Illuminate\Support\Facades\Http;

class ProvidersTest extends TestCase
{
    public function test_cloudflare_turnstile_success()
    {
        config()->set('antibot.default', 'turnstile');
        config()->set('antibot.providers.turnstile.secret', 'secret_key');

        Http::fake([
            '*' => Http::response(['success' => true], 200)
        ]);

        $result = AntiBot::verify('valid_token');

        $this->assertTrue($result->success);
    }

    public function test_cloudflare_turnstile_failure()
    {
        config()->set('antibot.default', 'turnstile');
        config()->set('antibot.providers.turnstile.secret', 'secret_key');

        Http::fake([
            '*' => Http::response(['success' => false, 'error-codes' => ['invalid-input-response']], 200)
        ]);

        $result = AntiBot::verify('invalid_token');

        $this->assertFalse($result->success);
        $this->assertContains('invalid-input-response', $result->errors);
    }

    public function test_recaptcha_v2_success()
    {
        config()->set('antibot.default', 'recaptcha_v2');
        config()->set('antibot.providers.recaptcha_v2.secret', 'secret_key');

        Http::fake([
            '*' => Http::response(['success' => true], 200)
        ]);

        $result = AntiBot::verify('valid_token');

        $this->assertTrue($result->success);
    }

    public function test_recaptcha_v3_score_too_low()
    {
        config()->set('antibot.default', 'recaptcha_v3');
        config()->set('antibot.providers.recaptcha_v3.secret', 'secret_key');
        config()->set('antibot.providers.recaptcha_v3.score', 0.5);

        Http::fake([
            '*' => Http::response(['success' => true, 'score' => 0.4], 200)
        ]);

        $result = AntiBot::verify('valid_token');

        $this->assertFalse($result->success);
        $this->assertContains('score-too-low', $result->errors);
    }

    public function test_recaptcha_v3_success()
    {
        config()->set('antibot.default', 'recaptcha_v3');
        config()->set('antibot.providers.recaptcha_v3.secret', 'secret_key');
        config()->set('antibot.providers.recaptcha_v3.score', 0.5);

        Http::fake([
            '*' => Http::response(['success' => true, 'score' => 0.9, 'action' => 'login'], 200)
        ]);

        $result = AntiBot::verify('valid_token', null, 'login');

        $this->assertTrue($result->success);
    }

    public function test_recaptcha_v3_action_mismatch()
    {
        config()->set('antibot.default', 'recaptcha_v3');
        config()->set('antibot.providers.recaptcha_v3.secret', 'secret_key');
        config()->set('antibot.providers.recaptcha_v3.score', 0.5);

        Http::fake([
            '*' => Http::response(['success' => true, 'score' => 0.9, 'action' => 'login'], 200)
        ]);

        // Esperamos 'register', pero el response es 'login'
        $result = AntiBot::verify('valid_token', null, 'register');

        $this->assertFalse($result->success);
        $this->assertContains('action-mismatch', $result->errors);
    }
}

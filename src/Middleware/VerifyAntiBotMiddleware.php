<?php

declare(strict_types=1);

namespace Abitech\AntiBot\Middleware;

use Closure;
use Illuminate\Http\Request;
use Abitech\AntiBot\Facades\AntiBot;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyAntiBotMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $action
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ?string $action = null)
    {
        $token = $request->header('X-AntiBot-Token') ?? $request->input('antibot_token');

        if (empty($token) || !is_string($token)) {
            throw new HttpException(403, trans('antibot::validation.antibot'));
        }

        $result = AntiBot::verify($token, $request->ip(), $action);

        if (!$result->success) {
            $message = trans('antibot::validation.antibot');

            if ($result->errors) {
                if (in_array('action-mismatch', $result->errors, true)) {
                    $message = trans('antibot::validation.antibot_action');
                } elseif (in_array('score-too-low', $result->errors, true)) {
                    $message = trans('antibot::validation.antibot_score');
                }
            }

            throw new HttpException(403, $message);
        }

        return $next($request);
    }
}

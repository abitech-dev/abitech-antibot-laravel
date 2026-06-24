<?php

declare(strict_types=1);

namespace Abitech\AntiBot\Rules;

use Abitech\AntiBot\Facades\AntiBot;
use Illuminate\Contracts\Validation\Rule;

class AntiBotRule implements Rule
{
    /** @var string|null */
    protected $action;

    /** @var string|null */
    protected $errorMessage;

    public function __construct(?string $action = null)
    {
        $this->action = $action;
    }

    /**
     * Determina si la regla de validación pasa. (Compatible con Laravel <= 9)
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!is_string($value)) {
            $this->errorMessage = trans('antibot::validation.antibot');
            return false;
        }

        $ip = request()->ip();
        
        $result = AntiBot::verify($value, $ip, $this->action);

        if (!$result->success) {
            if ($result->errors && in_array('action-mismatch', $result->errors, true)) {
                $this->errorMessage = trans('antibot::validation.antibot_action');
            } elseif ($result->errors && in_array('score-too-low', $result->errors, true)) {
                $this->errorMessage = trans('antibot::validation.antibot_score');
            } else {
                $this->errorMessage = trans('antibot::validation.antibot');
            }
            return false;
        }

        return true;
    }

    /**
     * Obtiene el mensaje de error de la validación.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->errorMessage ?: trans('antibot::validation.antibot');
    }

    /**
     * Invokable rule (Compatible con Laravel >= 10)
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }
}

<?php

declare(strict_types=1);

namespace Abitech\AntiBot\DTOs;

class VerificationResult
{
    /** @var bool */
    public $success;

    /** @var float|null */
    public $score;

    /** @var array|null */
    public $errors;

    /** @var string|null */
    public $action;

    public function __construct(
        bool $success,
        ?float $score = null,
        ?array $errors = null,
        ?string $action = null
    ) {
        $this->success = $success;
        $this->score = $score;
        $this->errors = $errors;
        $this->action = $action;
    }
}

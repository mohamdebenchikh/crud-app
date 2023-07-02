<?php

namespace App\Validation\Rules;

interface RuleInterface
{
    public function validate(): bool;
    public function getMessage(): string;
}

<?php

namespace App\Validation\Rules;

class MaxRule implements RuleInterface
{
    protected $field;
    protected $value;
    protected $param;

    public function __construct($field, $value, $param)
    {
        $this->field = $field;
        $this->value = $value;
        $this->param = $param;
    }

    public function validate(): bool
    {
        if (is_string($this->value)) {
            return strlen($this->value) <= intval($this->param);
        }

        if (is_numeric($this->value)) {
            return $this->value <= intval($this->param);
        }

        if (is_file($this->value['tmp_name'])) {
            $fileSizeInBytes = floor(filesize($this->value['tmp_name']));
            $fileSizeInKB = $fileSizeInBytes / 1024;
            return $fileSizeInKB <= intval($this->param);
        }

        return false;
    }

    public function getMessage(): string
    {
        if (is_string($this->value)) {
            return "The {$this->field} must be less than or equal to {$this->param} characters.";
        }

        if (is_numeric($this->value)) {
            return "The {$this->field} must be less than or equal to {$this->param}.";
        }

        if (is_file($this->value['tmp_name'])) {
            return "The size of {$this->field} must be less than or equal to {$this->param} bytes.";
        }

        return '';
    }
}

<?php

namespace App\Validation\Rules;

class FileRule implements RuleInterface
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

    public function validate():bool
    {
        return  empty($this->value) || is_file($this->value['tmp_name']);
    }

    public function getMessage() : string
    {
        return "The {$this->field} must be a file.";
    }
}

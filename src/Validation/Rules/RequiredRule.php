<?php

namespace App\Validation\Rules;

class RequiredRule implements RuleInterface
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
        return !empty($this->value);
    }

    public function getMessage() : string
    {
        return "The {$this->field} is required.";
    }
}

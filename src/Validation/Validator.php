<?php

namespace App\Validation;

class Validator
{
    protected $data;
    protected $errors = [];
    protected $ruleNamespace = 'App\Validation\Rules';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function validate(array $rules)
    {
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $singleRule) {
                if (strpos($singleRule, ':') !== false) {
                    [$ruleName, $param] = explode(':', $singleRule);
                } else {
                    $ruleName = $singleRule;
                    $param = '';
                }
                $this->applyRule($field, $ruleName, $param);
            }
        }

        return $this;
    }

    public function passes()
    {
        return empty($this->errors);
    }

    public function fails()
    {
        return !$this->passes();
    }

    public function errors()
    {
        return $this->errors;
    }

    protected function applyRule($field, $ruleName, $param)
    {
        $value = $this->data[$field];
        $ruleClassName = $this->ruleNamespace . '\\' . ucfirst($ruleName).'Rule';

        if (class_exists($ruleClassName)) {
            $ruleInstance = new $ruleClassName($field, $value, $param);
            if (!$ruleInstance->validate()) {
                $this->addError($field, $ruleInstance->getMessage());
            }
        } else {
            // Rule class not found, handle accordingly
            // For example, you can throw an exception or log an error.
        }
    }

    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }
}

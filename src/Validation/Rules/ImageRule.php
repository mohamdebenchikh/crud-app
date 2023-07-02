<?php

namespace App\Validation\Rules;

class ImageRule implements RuleInterface
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
        $allowedExtensions = $this->param ? explode(',',$this->param) : false;

        if ($allowedExtensions === false) {
            return false; // Invalid parameter, no allowed extensions specified
        }

        if (!is_file($this->value['tmp_name'])) {
            return false; // File does not exist
        }

        $imageInfo = getimagesize($this->value['tmp_name']);
        $extension = image_type_to_extension($imageInfo[2], false);

        return in_array($extension, $allowedExtensions);
    }

    public function getMessage(): string
    {
        return "The '{$this->field}' must be an image file with one of the following extensions: {$this->param}.";
    }
}

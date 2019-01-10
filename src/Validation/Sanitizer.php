<?php
namespace Validation;

class Sanitizer
{
    public function spaceTrim($value)
    {
        return trim($value);
    }
}
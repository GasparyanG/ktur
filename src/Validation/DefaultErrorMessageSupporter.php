<?php
namespace Validation;

class DefaultErrorMessageSupporter
{
    public function __construct()
    {
        $this->defaultMessages = [
            "length" => [
                "min" => "%s need to have at least %d characters",
                "max" => "%s need to have not more than %d characters",
            ],
            "numeric" => "%s need to be only numbers",
            "alphanumeric" => "%s need to have only alpabetic or numeric characters",
            "notzero" => "%s need to be choosed",
            "image-upload" => "%s need to be added"
        ];
    }

    public function getDefaultErrorMessage(string $keyForDefaultMessage, string $fieldName, array $arrayOfOptions = null): string
    {
        // kys need to be in lowercase
        $keyForDefaultMessage = strtolower($keyForDefaultMessage);

        if (!isset($this->defaultMessages[$keyForDefaultMessage])) {
            throw new \InvalidArgumentException("$keyForDefaultMessage need to have default error message");
        }

        $hasOptions = $this->hasOptions($keyForDefaultMessage);

        if (!$hasOptions) {
            return sprintf($this->defaultMessages[$keyForDefaultMessage], $fieldName);
        }

        if (!$arrayOfOptions) {
            throw new \InvalidArgumentException("$fieldName's array of options is not defined to get appropriate error message");
        }

        return $this->getErrorMessageBasedOnOption($keyForDefaultMessage, $fieldName, $arrayOfOptions);
    }

    private function hasOptions(string $fieldName): bool
    {
        $value = $this->defaultMessages[$fieldName];

        if (is_array($value)) {
            return true;
        }

        return false;
    }

    private function getErrorMessageBasedOnOption(string $keyForDefaultMessage ,string $fieldName, array $arrayOfOptions): string
    {
        foreach($arrayOfOptions as $option => $value) {
            $option = strtolower($option);
            // if this point is reached then field existance in assco array is true!
            if (isset($this->defaultMessages[$keyForDefaultMessage][$option])) {
                $errorMessageFormatted = sprintf($this->defaultMessages[$keyForDefaultMessage][$option], $fieldName, $value);
                
                return $errorMessageFormatted;
            }

            throw new \InvalidArgumentException("$option for $fieldName don't have any error messages");
        }
    }
}
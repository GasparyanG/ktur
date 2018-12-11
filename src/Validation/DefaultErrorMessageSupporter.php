<?php
namespace Validation;

class DefaultErrorMessageSupporter
{
    public function __construct()
    {
        $this->defaultMessages = [
            "length" => [
                "min" => "%s need to have at least %d character",
                "max" => "%s need to have not more than %d character",
            ],
            "numeric" => "%s need to be only numbers",
            "alphanumeric" => "%s nned to have only alpabetic or numeric characters",
        ];
    }

    public function getDefaultErrorMessage(string $keyForDefaultMessage, string $fieldName, array $arrayOfOptions = null): string
    {
        if (!isset($this->defaultMessages[$keyForDefaultMessage])) {
            throw new \InvalidArgumentException("$keyForDefaultMessage need to have default error message");
        }

        $hasOptions = $this->hasOptions($keyForDefaultMessage);

        if (!$hasOptions) {
            return $this->defaultMessages[$keyForDefaultMessage];
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
            // if this point is reached then field existance in assco array is true!
            if (isset($this->defaultMessages[$keyForDefaultMessage][$option])) {
                $errorMessageFormatted = sprintf($this->defaultMessages[$keyForDefaultMessage][$option], $fieldName, $value);
                
                return $errorMessageFormatted;
            }

            throw new \InvalidArgumentException("$option for $fieldName don't have any error messages");
        }
    }
}
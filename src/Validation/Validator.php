<?php 
namespace Validation;

class Validator
{
    public function __construct()
    {
        /**
         * unmatched values will be appended to this array
         */
        $this->errorMessages = [];

        $this->lengthOptions = [
            "MIN" => "greaterOrEqualThan",
            "MAX" => "lessOrEqualThan(",
        ];
    }

    /**
     * @param string $parsedBodyValue value which need to be valdated
     * @param int[] $options assoc array which will tell what kind of operations need to be done:
     *      e.g. lenght need to be less than or geater than specified value
     * @param string|null $errorMessage if validation is false then add errMessage will be appended to 
     *      $this->errorMessages!
     */
    public function isLength(string $parsedBodyValue, array $options, string $errorMessage)
    {
        list($option, $value) = $this->fetchKeyValue($options);

        $methodName = $this->getMethodName($option);

        if (!$this->$methodName($parsedBodyValue, $value)) {
            $this->errorMessages[] = $errorMessage;
        }
    }

    private function fetchKeyValue(array $options)
    {
        if (count($options) > 1) {
            throw new InvalidArgumentException("length of passed array is greater than 1");
        }

        $keyAndValue = [];
        foreach($options as $key => $value) {
            $keyAndValue[] = $key;
            $keyAndValue[] = $value;
        }

        return $keyAndValue;
    }

    private function getMethodName($option)
    {
        $option = strtoupper($option);

        if (!isset($this->lengthOptions[$option])) {
            throw new InvalidArgumentException("given length option is wrong");
        }

        return $this->lengthOptions[$option];
    }

    private function greaterOrEqualThan(string $parsedBodyValue, int $value): bool
    {
        if (strlen($parsedBodyValue) >= $value) {
            return true;
        }

        return false;
    }

    private function lessOrEqualThan(string $parsedBodyValue, int $value): bool
    {
        if (strlen($parsedBodyValue) <= $value) {
            return true;
        }

        return false;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}
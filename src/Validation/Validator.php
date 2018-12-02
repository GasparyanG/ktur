<?php 
namespace Validation;

class Validator
{
    public function __construct()
    {
        /**
         * unmatched values will be appended to this array
         * 
         * @property string[] assoc array:
         *      key => error risen input feald name
         *      value => error message
         */
        $this->errorMessages = [];

        $this->lengthOptions = [
            "MIN" => "greaterOrEqualThan",
            "MAX" => "lessOrEqualThan(",
        ];
    }

    /**
     * @param string[] assoc array $fealdNameValuePair value which need to be valdated
     * @param int[] $options assoc array which will tell what kind of operations need to be done:
     *      e.g. lenght need to be less than or geater than specified value
     * @param string|null $errorMessage if validation is false then add errMessage will be appended to 
     *      $this->errorMessages!
     */
    public function isLength(array $fealdNameValuePair, array $options, string $errorMessage)
    {
        list($option, $value) = $this->fetchKeyValue($options);

        /**
         * assoc array's feald name is needed to know what feald is triggered error
         * error message is needed to know what kind of error is triggered
         */
        $fealdNameValuePair = $this->convertToRegularArray($fealdNameValuePair);
        list($fealdName, $fealdValue) = $fealdNameValuePair;

        $methodName = $this->getMethodName($option);

        if (!$this->$methodName($fealdValue, $value)) {
            $this->errorMessages[$fealdName] = $errorMessage;
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

    private function greaterOrEqualThan(string $fealdValue, int $value): bool
    {
        if (strlen($fealdValue) >= $value) {
            return true;
        }

        return false;
    }

    private function lessOrEqualThan(string $fealdValue, int $value): bool
    {
        if (strlen($fealdValue) <= $value) {
            return true;
        }

        return false;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    private function convertToRegularArray($fealdNameValuePair)
    {
        $regularArray = [];
        foreach($fealdNameValuePair as $fealdName => $errorMessage) {
            $regularArray[] = $fealdName;
            $regularArray[] = $errorMessage;
        }

        return $regularArray;
    }
}
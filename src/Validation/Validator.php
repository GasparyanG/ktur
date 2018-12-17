<?php 
namespace Validation;

use Validation\DefaultErrorMessageSupporter as DefaultErrorMessageSupporter;
use Validation\SpecificValidators\FileUploadValidation\FileUploadValidator as FileUploadValidator;

class Validator
{
    public function __construct()
    {
        $this->fileUploadValidator = new FileUploadValidator();

        $this->defaultErrorMessageSupporter = new DefaultErrorMessageSupporter();
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
            "MAX" => "lessOrEqualThan",
        ];

        $this->keysForDefaultErrorMessages = [
            "length" => "length",
            "numeric" => "numeric",
            "alphanumeric" => "alphanumeric"
        ];
    }

    /**
     * @param string[] assoc array $fealdNameValuePair value which need to be valdated
     * @param int[] $options assoc array which will tell what kind of operations need to be done:
     *      e.g. lenght need to be less than or geater than specified value
     * @param string|null $errorMessage if validation is false then add errMessage will be appended to 
     *      $this->errorMessages!
     */
    public function isLength(array $fealdNameValuePair, array $options, string $errorMessage = null)
    {
        list($option, $value) = $this->fetchKeyValue($options);

        /**
         * assoc array's feald name is needed to know what feald is triggered error
         * error message is needed to know what kind of error is triggered
         */
        $fealdNameValuePair = $this->convertToRegularArray($fealdNameValuePair);
        list($fieldName, $fealdValue) = $fealdNameValuePair;

        $methodName = $this->getMethodName($option);

        if (!$this->$methodName($fealdValue, $value)) {
            if ($errorMessage === null) {
                $errorMessage = $this->defaultErrorMessageSupporter->getDefaultErrorMessage($this->keysForDefaultErrorMessages['length'],
                $fieldName, $options);
                $this->errorMessages[$fieldName] = $errorMessage;
            }
        }
    }

    // error messages is need to be default
    public function isNumeric($fieldName, $fieldValue)
    {
        if (!is_numeric($fieldValue)) {
            $defaultErrorMessage = $this->defaultErrorMessageSupporter->getDefaultErrorMessage($this->keysForDefaultErrorMessages['numeric'],
            $fieldName);
            
            $this->errorMessages[$fieldName] = $defaultErrorMessage;
        }
    }

    public function isAlphaNumeric($fieldName, $fieldValue)
    {
        if (!ctype_alnum($fieldValue)) {
            $defaultErrorMessage = $this->defaultErrorMessageSupporter->getDefaultErrorMessage($this->keysForDefaultErrorMessages['alphanumeric'],
            $fieldName);

            $this->errorMessages[$fieldName] = $defaultErrorMessage;   
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

    public function notZero($fieldName, $fieldValue)
    {
        if ($fieldValue === 0) {
            $defaultErrorMessage = $this->defaultErrorMessageSupporter->getDefaultErrorMessage("notZero", $fieldName);
            $this->errorMessages[$fieldName] = $defaultErrorMessage;
        }
    }

    public function vaildateFileState($fieldName, $fieldValue)
    {
        if (!$this->fileUploadValidator->haveItemToSave($fieldValue)) {
            $defaultErrorMessageForFile = $this->defaultErrorMessageSupporter->getDefaultErrorMessage($fieldName, "image-upload`");

            $this->errorMessages[$fieldName] = $defaultErrorMessageForFile;
        }
    }
}
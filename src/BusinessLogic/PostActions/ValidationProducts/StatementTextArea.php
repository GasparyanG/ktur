<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class StatementTextArea
{
    public function isValid($fieldName)
    {
        return $fieldName === "statementTextArea";
    }

    public function execute($fieldName, $filedValue, $validator)
    {
        $validator->isLength([$fieldName => $filedValue], ["min" => 2]);
    }
}
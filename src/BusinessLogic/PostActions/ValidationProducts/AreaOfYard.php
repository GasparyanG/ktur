<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class AreaOfYard
{
    public function isValid($fieldName)
    {
        return $fieldName === "yardArea";
    }

    public function execute($fieldName, $fieldValue, $validator)
    {
        $validator->isNumeric($fieldName, $fieldValue);
    }
}
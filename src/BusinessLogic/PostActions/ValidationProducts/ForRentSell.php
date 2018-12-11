<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class ForRentSell
{
    public function isValid($fieldName)
    {
        return $fieldName === "rentSell";
    }

    public function execute($fieldName, $fieldValue, $validator)
    {
        $validator->isAlphaNumeric($fieldName, $fieldValue);
    }
}
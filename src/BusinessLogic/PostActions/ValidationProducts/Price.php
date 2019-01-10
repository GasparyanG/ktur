<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class Price
{
    public function isValid($fieldName)
    {
        return $fieldName === "price";
    }

    public function execute($fieldName, $fieldValue, $validator)
    {
        $validator->isNumeric($fieldName, $fieldValue);
    }
}
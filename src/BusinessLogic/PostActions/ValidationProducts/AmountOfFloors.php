<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class AmountOfFloors
{
    public function isValid($fieldName)
    {
        return $fieldName === "floorAmount";
    }

    public function execute($fieldName, $fieldValue, $validator)
    {
        $validator->isNumeric($fieldName, $fieldValue);
    }
}
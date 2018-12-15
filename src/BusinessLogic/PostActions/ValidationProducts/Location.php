<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class Location
{
    public function isValid($fieldName)
    {
        return $fieldName === "location";
    }

    public function execute($fieldName, $fieldValue, $validator)
    {
        $validator->notZero($fieldName, $fieldValue);
    }
}
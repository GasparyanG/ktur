<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class Title
{
    public function isValid($fieldName)
    {
        return $fieldName === "title";
    }

    public function execute($fieldName, $fieldValue, $validator)
    {
        $validator->isLength([$fieldName => $fieldValue], ["MIN" => 1]);
    }
}
<?php
namespace BusinessLogic\PostActions\ValidationProductFactory;

class Factory
{
    public function __construct()
    {
        // services that serves validation specific calls
        $this->products = [

        ];
    }

    public function create($fieldName, $fieldValue, $validator)
    {
        foreach($this->products as $product) {
            if ($product->isValid($fieldName)) {
                $product->execute($fieldName, $fieldValue, $validator);
                break;
            }
        }
    }
}
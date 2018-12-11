<?php
namespace BusinessLogic\PostActions\ValidationProductFactory;

class Factory
{
    public function __construct()
    {
        $this->validationProductsNamespace = "BusinessLogic\PostActions\ValidationProducts\\";

        // services that serves validation specific calls
        $this->productsNames = [
            'AreaOfBuilding',
            'ForRentSell',
            'AmountOfFloors',
            'AreaOfYard',
            'Price',
        ];
    }

    public function validate($fieldName, $fieldValue, $validator)
    {
        foreach($this->productsNames as $productName) {
            $productFullyQualifiedNamespace = $this->validationProductsNamespace . $productName;
            $product = new $productFullyQualifiedNamespace();

            if ($product->isValid($fieldName)) {
                $product->execute($fieldName, $fieldValue, $validator);
                break;
            }
        }
    }
}
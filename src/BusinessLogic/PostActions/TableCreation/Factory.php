<?php
namespace BusinessLogic\PostActions\TableCreation;

class Factory
{
    public function __construct()
    {
        $this->fullyQualifiedNamespacePrefix = "BusinessLogic\PostActions\TableCreation\TableCreationProducts\\";
        $this->productsNames = [
            "IndependentHouse",
        ];   
    }

    public function makeRecord(string $statementType, array $statementFormData, $routeInfo)
    {
        foreach($this->productsNames as $productName) {
            $fullyQualifiedNamespace = $this->fullyQualifiedNamespacePrefix . $productName;
            $product = new $fullyQualifiedNamespace();

            if ($product->isUsed($statementType)) {
                $product->execute($statementFormData, $routeInfo);
                return $product->getInsertedId();
            }
        }
    }
}
<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\AbstractFactory;

class AbstractFactory
{
    public function __construct()
    {
        $this->dirNamespace = "DataBase\DBSpecificRequests\Statements\StatementsRepresentation\AbstractFactory\Products\\";
        $this->productsNames = [
            "IndHouseComponents",
        ];
    }

    public function create($statementType)
    {
        foreach($this->productsNames as $productName) {
            $fullyQualifiedNamespace = $this->dirNamespace . $productName;
            $product = new $fullyQualifiedNamespace();

            if ($product->isUsed($statementType)) {
                return $product;
            }
        }
    }
}
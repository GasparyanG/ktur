<?php
namespace BusinessLogic\ActorOnStatement\Factories;

use DataBase\Implementations\DBManipulator;
use Interactions\Config\ConfigFetcher;

class DeletionFactory
{
    public function __construct()
    {
        $this->dbmanipulator = new DBManipulator();
        $this->configFetcher = new ConfigFetcher();

        $this->namespaceDir = "BusinessLogic\ActorOnStatement\ProductsOfFactory\DeletionProducts\\";
        $this->productsNames = [
            "IndHouse",
        ];
    }

    public function deleteStatement(string $tableName, $uniqueIdentifier): void
    {
        foreach($this->productsNames as $productName) {
            $fullyQualifiedNamespace = $this->namespaceDir . $productName;
            $product = new $fullyQualifiedNamespace($this->configFetcher, $this->dbmanipulator);
            
            if ($product->isUsed($tableName)) {
                $product->execute($uniqueIdentifier);
            }
        }
    }
}
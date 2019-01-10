<?php
namespace BusinessLogic\ActorOnStatement\Factories;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use DataBase\Implementations\DBManipulator as DBManipulator;

class BasketFactory
{
    public function __construct()
    {
        $this->dbmanipulator = new DBManipulator();
        $this->configFetcher = new ConfigFetcher();

        $this->dirLvlNamespace = "BusinessLogic\ActorOnStatement\ProductsOfFactory\BasketProducts\\";

        $this->productsNames = [
            "IndHouse"
        ];
    }

    public function addStatementToBasket(string $tableName, string $uniqueIdentifier, string $username): void
    {
        foreach($this->productsNames as $productName) {
            $fullyQualifiedNamespace = $this->dirLvlNamespace . $productName;
            $product = new $fullyQualifiedNamespace($this->configFetcher, $this->dbmanipulator);
            
            if ($product->isUsed($tableName)) {
                $product->execute($uniqueIdentifier, $username);
            }
        }
    }
}
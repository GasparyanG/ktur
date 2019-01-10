<?php
namespace BusinessLogic\ActorOnStatement\Factories;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use DataBase\Implementations\DBManipulator as DBManipulator;

class StarFactory
{
    public function __construct()
    {
        // objects to rely on
        $this->dbmanipulator = new DBManipulator();
        $this->configFetcher = new ConfigFetcher();

        $this->dirLvlNamespace = "BusinessLogic\ActorOnStatement\ProductsOfFactory\StarProducts\\";

        $this->productsNames = [
            "IndHouse"
        ];
    }

    public function addStar(string $tableName, string $uniqueIdentifier, string $username)
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
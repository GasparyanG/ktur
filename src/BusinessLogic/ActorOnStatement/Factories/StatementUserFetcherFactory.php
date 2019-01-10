<?php
namespace BusinessLogic\ActorOnStatement\Factories;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use DataBase\Implementations\DBManipulator as DBManipulator;

class StatementUserFetcherFactory
{
    public function __construct()
    {
        // product will be used based on table name, which will be by this object!
        $this->configFetcher = new ConfigFetcher();
        $this->dbmanipulator = new DBManipulator();

        $this->productDirNamespace = "BusinessLogic\ActorOnStatement\ProductsOfFactory\StatementUserFetchers\\";
        $this->products = [
            "IndHouse",
        ];
    }

    public function create(string $tablName)
    {
        foreach($this->products as $product) {
            $fullyQualifiedNamespace = $this->productDirNamespace . $product;
            $object = new $fullyQualifiedNamespace($this->configFetcher, $this->dbmanipulator);

            if ($object->isUsed($tablName)) {
                return $object;
            }
        }
    }
}
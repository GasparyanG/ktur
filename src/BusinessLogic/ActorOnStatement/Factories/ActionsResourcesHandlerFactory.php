<?php
namespace BusinessLogic\ActorOnStatement\Factories;

use DataBase\Implementations\DBManipulator;
use Interactions\Config\ConfigFetcher;

class ActionsResourcesHandlerFactory
{
    private $productsNames;
    private $namespaceDir;

    public function __construct()
    {
        $this->dbmanipulator = new DBManipulator();
        $this->configFetcher = new ConfigFetcher();

        $this->namespaceDir = "BusinessLogic\ActorOnStatement\ProductsOfFactory\ActionsResourcesHandlers\\";
        $this->productsNames = [
            "IndHouse",
        ];
    }

    public function create(string $statementType)
    {
        foreach($this->productsNames as $productName) {
            $fullyQualifiedNamespace = $this->namespaceDir . $productName;
            $product = new $fullyQualifiedNamespace($this->dbmanipulator, $this->configFetcher);

            if ($product->isUsed($statementType)) {
                return $product;
            }
        }
    }
}
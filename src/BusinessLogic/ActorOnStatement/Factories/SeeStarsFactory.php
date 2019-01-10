<?php
namespace BusinessLogic\ActorOnStatement\Factories; 

class SeeStarsFactory
{
    public function __construct()
    {
        $this->dirNamespace = "DataBase\Tables\\";
        $this->productNames = [
            "ind-houses" => "IndHouseStar",
        ];
    }

    public function create(string $tableName)
    {
        $productName = $this->getProductName($tableName);
        $fullyQualifiedNamespace = $this->dirNamespace . $productName;

        return new $fullyQualifiedNamespace();
    }

    public function getProductName($tableName): string
    {
        $lowerCase = strtolower($tableName);

        if (isset($this->productNames[$lowerCase])) {
            return $this->productNames[$lowerCase];
        }

        throw new \InvalidArgumentException("$lowerCase is not defined");
    }
}
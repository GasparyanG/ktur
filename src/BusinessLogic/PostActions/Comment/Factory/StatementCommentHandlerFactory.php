<?php
namespace BusinessLogic\PostActions\Comment\Factory;

class StatementCommentHandlerFactory
{
    private $productsNames;
    private $namespaceDir;

    public function __construct()
    {
        $this->namespaceDir = "BusinessLogic\PostActions\Comment\Products\\";
        $this->productNames = [
            "indHouse",
        ];
    }

    public function create(string $statementType)
    {
        foreach($this->productNames as $productName) {
            $fullyQualifiedNamespace = $this->namespaceDir . $productName;
            $product = new $fullyQualifiedNamespace();

            if ($product->isUsed($statementType)) {
                return $product;
            }
        }
    }
}
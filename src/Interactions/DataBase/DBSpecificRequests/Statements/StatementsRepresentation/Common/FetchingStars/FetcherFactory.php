<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\Common\FetchingStars;

use GuzzleHttp\Psr7\ServerRequest;

class FetcherFactory
{
    private $namespaceDir;    
    private $products;
    private $request;

    public function __construct()
    {
        $this->request = ServerRequest::FromGlobals();

        $this->namespaceDir = "DataBase\DBSpecificRequests\Statements\StatementsRepresentation\Common\FetchingStars\Fetchers\\";
        $this->products = [
            "ind_house" => "IndHouseStarFetcher",
        ];
    }

    public function fetch($nestedArray, $statementType, string $action = null)
    {
        $cookieParams = $this->request->getCookieParams();
        $username = "%";
        if (isset($cookieParams["username"])) {
            $username = $cookieParams["username"];
        }

        if ($action === "liked") {
            // DRY violation
            foreach($this->products as $statementTypeKey => $statementTypeImplementorName) {
                if ($statementTypeKey === $statementType) {
                    $productNamespace = $this->namespaceDir . $statementTypeImplementorName;
                    $product = new $productNamespace();
                    // true or false
                    return $product->isLiked($nestedArray, $username);
                }
            }    
        }

        foreach($this->products as $statementTypeKey => $statementTypeImplementorName) {
            if ($statementTypeKey === $statementType) {
                $productNamespace = $this->namespaceDir . $statementTypeImplementorName;
                $product = new $productNamespace();
                return $product->stars($nestedArray);
            }
        }
    }
}
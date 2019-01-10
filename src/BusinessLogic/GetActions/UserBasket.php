<?php
namespace BusinessLogic\GetActions;

use Augmention\Convertion\JsonConverter as JsonConverter;
use ClientSideGuru\Statement\ConstraintFetcher as ConstraintFetcher;
use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\BasketContentRepresentationCreator as BasketContentRepresentationCreator;

class UserBasket
{
    public function __construct()
    {
        $this->constraintFetcher = new ConstraintFetcher();
        $this->jsonConverter = new JsonConverter();
        $this->basketContentRepresentationCreator = new BasketContentRepresentationCreator();

        $this->clientData = [
            "title" => "Basket Content"
        ];
    }

    public function getUserBasketContent($req, $res, $routeInfo)
    {
        $res->render("/user/get-actions/basket/user-basket.html", ["title" => $this->clientData["title"]]);
    }

    public function getResources($req, $res, $routeInfo)
    {
        $username = $req->getCookieParams()['username'];
        
        $arrayOfOffSets = $this->constraintFetcher->getArrayOfOffsets();
        $statementType = $this->constraintFetcher->getStatementType();
        $filter = $this->constraintFetcher->getFilter();

        $resources = $this->basketContentRepresentationCreator->getStatementsResources($arrayOfOffSets, $username, $statementType, $filter);

        echo $this->jsonConverter->convertArrayToJson($resources);
    }
}
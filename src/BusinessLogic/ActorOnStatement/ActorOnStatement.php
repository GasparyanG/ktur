<?php
namespace BusinessLogic\ActorOnStatement;

use BusinessLogic\ActorOnStatement\Factories\StarFactory as StarFactory;
use BusinessLogic\ActorOnStatement\Factories\BasketFactory as BasketFactory;

class ActorOnStatement
{
    public function __construct()
    {
        $this->starFactory = new StarFactory();
        $this->basketFactory = new BasketFactory();
    }

    public function star($req, $res, $routeInfo)
    {
        $username = $req->getCookieParams()['username'];
        $tableName = $routeInfo["table-name"];
        $uniqueIdentifier = $routeInfo["unique-identifier"];

        $this->starFactory->addStar($tableName, $uniqueIdentifier, $username);
    }

    public function basket($req, $res, $routeInfo)
    {
        $username = $req->getCookieParams()['username'];
        $tableName = $routeInfo["table-name"];
        $uniqueIdentifier = $routeInfo['unique-identifier'];

        $this->basketFactory->addStatementToBasket($tableName, $uniqueIdentifier, $username);
    }
}
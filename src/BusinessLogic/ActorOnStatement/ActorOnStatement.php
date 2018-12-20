<?php
namespace BusinessLogic\ActorOnStatement;

use BusinessLogic\ActorOnStatement\Factories\StarFactory as StarFactory;

class ActorOnStatement
{
    public function __construct()
    {
        $this->starFactory = new StarFactory();
    }

    public function star($req, $res, $routeInfo)
    {
        $username = $req->getCookieParams()['username'];
        $tableName = $routeInfo["table-name"];
        $uniqueIdentifier = $routeInfo["unique-identifier"];

        $this->starFactory->addStar($tableName, $uniqueIdentifier, $username);
    }
}
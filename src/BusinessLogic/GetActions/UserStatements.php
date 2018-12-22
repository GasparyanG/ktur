<?php
namespace BusinessLogic\GetActions;

class UserStatements
{
    public function __construct()
    {
        $this->clientData = [
            'title' => "Statements",
        ];
    }

    public function getUserStatements($req, $res, $routeInfo)
    {
        $res->render("/user/get-actions/statement/user-statements.html", ['title' => $this->clientData['title']]);
    }

    public function getResources($req, $res, $routeInfo)
    {
        echo "sth";
    }
}
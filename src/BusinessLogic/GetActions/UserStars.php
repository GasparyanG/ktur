<?php
namespace BusinessLogic\GetActions;

use ClientSideGuru\Statement\ConstraintFetcher as ConstraintFetcher;
use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\UserStatementsStarsRepresentationCreator as UserStatementsStarsRepresentationCreator; 

class UserStars
{
    public function __construct()
    {
        $this->constraintFetcher = new ConstraintFetcher();
        $this->userStatementsStarsRepresentationCreator = new UserStatementsStarsRepresentationCreator();

        $this->clientData = [
            "title" => "Statements Stars"
        ];
    }

    public function getUserStatementsStars($req, $res, $routeInfo)
    {
        $username = $req->getCookieParams()['username'];
        $title = $username . "'s " . $this->clientData['title'];

        $res->render("/user/get-actions/stars/user-stars.html", ["title" => $title]);
    }

    public function getResources($req, $res, $routeInfo)
    {
        $username = $req->getCookieParams()['username'];
        
        $arrayOfOffSets = $this->constraintFetcher->getArrayOfOffsets();
        $statementType = $this->constraintFetcher->getStatementType();
        $filter = $this->constraintFetcher->getFilter();

        $resources = $this->userStatementsStarsRepresentationCreator->getStatementsResources($arrayOfOffSets, $username, $statementType, $filter);

        echo $this->jsonConverter->convertArrayToJson($resources);
    }
}
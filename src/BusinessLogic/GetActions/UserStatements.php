<?php
namespace BusinessLogic\GetActions;

use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\StatementsRepresentationCreator as StatementsRepresentationCreator;
use Augmention\Convertion\JsonConverter as JsonConverter;
use ClientSideGuru\Statement\ConstraintFetcher as ConstraintFetcher;

class UserStatements
{
    public function __construct()
    {
        $this->constraintFetcher = new ConstraintFetcher();
        $this->statementsRepresentationCreator = new StatementsRepresentationCreator();
        $this->jsonConverter = new JsonConverter();

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
        $username = $routeInfo['user-name'];

        $arrayOfOffSets = $this->constraintFetcher->getArrayOfOffsets();
        $statementType = $this->constraintFetcher->getStatementType();
        $filter = $this->constraintFetcher->getFilter();

        // (array $offSetArray, string $username = null, string $statementType = null, string $filter): array
        $resources = $this->statementsRepresentationCreator->getStatementsResources($arrayOfOffSets, $username, $statementType, $filter);

        echo $this->jsonConverter->convertArrayToJson($resources);
    }
}
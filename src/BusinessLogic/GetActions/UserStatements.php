<?php
namespace BusinessLogic\GetActions;

use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\StatementsRepresentationCreator as StatementsRepresentationCreator;
use Augmention\Convertion\JsonConverter as JsonConverter;

class UserStatements
{
    public function __construct()
    {
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

        $decdedDataFromClient = $this->jsonConverter->jsonDecodeWithFileGetContents();
        // this have to be defined in separate object!
        $arrayOfOffSets = $this->getArrayOfOffsets($decdedDataFromClient);
        $statementType = $this->getStatementType($decdedDataFromClient);
        $filter = $this->getFilter($decdedDataFromClient);

        // (array $offSetArray, string $username = null, string $statementType = null, string $filter): array
        $resources = $this->statementsRepresentationCreator->getStatementsResources($arrayOfOffSets, $username, $statementType, $filter);

        echo $this->jsonConverter->convertArrayToJson($resources);
    }

    private function getArrayOfOffsets(array $decdedDataFromClient): array
    {
        if (isset($decdedDataFromClient["statementOffsets"])) {
            $arrayOfOffSets = $decdedDataFromClient["statementOffsets"];
        }

        else {
            throw new \InvalidArgumentException("statementOffsets need to be defined in clinet side!");
        }

        return $decdedDataFromClient["statementOffsets"];
    }

    private function getStatementType(array $decdedDataFromClient)
    {
        if (isset($decdedDataFromClient["statementType"])) {
            return $decdedDataFromClient["statementType"];
        }

        return null;
    }

    private function getFilter(array $decdedDataFromClient): string
    {
        if (isset($decdedDataFromClient["filter"])) {
            return $decdedDataFromClient["filter"];
        }

        throw new \InvalidArgumentException("filter is needed to be defind in client side!");
    }
}
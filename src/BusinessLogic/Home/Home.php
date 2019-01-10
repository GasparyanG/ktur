<?php
namespace BusinessLogic\Home;

use ClientSideGuru\QueryStringParamsPreparing\QueryParamsPreparer;
use DataBase\DBSpecificRequests\Statements\StatementsRepresentation\StatementsRepresentationCreator;
use Augmention\Convertion\JsonConverter;
use ClientSideGuru\QueryStringParamsPreparing\FiltersInQueryString;

class Home
{
    public function __construct()
    {
        $this->jsonConverter = new JsonConverter();
        $this->statementsRepresentationCreator = new StatementsRepresentationCreator();
        $this->filtersInQueryString = new FiltersInQueryString();
    }

    public function getHomePage($req, $res, $routeInfo)
    {
        $res->render("home/main-layout.html", ["title" => "Home"]);
    }

    public function getPageSupportingHrefs($req, $res, $routeInfo)
    {
        echo "hi there";
    }

    public function getStatementResources($req, $res, $routeInfo)
    {
        $username = $this->getUsername($routeInfo);

        $queryParams = $req->getQueryParams();

        $arrayOfFilters = $this->validateFilters($queryParams);

        $queryParamsPreparer = new QueryParamsPreparer($queryParams);
        $offSetsArray = $queryParamsPreparer->getOffSetsArray();
        $filter = $queryParamsPreparer->getFilter();
        $statementType = $queryParamsPreparer->getStatementType();

        $statementsRequredData = $this->statementsRepresentationCreator->getStatementsResources($offSetsArray, $username, $statementType, $filter, $arrayOfFilters);
        echo $this->jsonConverter->convertArrayToJson($statementsRequredData);
    }

    private function getUsername($routeInfo)
    {
        if(isset($routeInfo["user-name"])) {
            return $routeInfo["user-name"];
        }

        return null;
    }

    private function validateFilters(array $queryParams)
    {
        $errorsAndFilters = $this->filtersInQueryString->getFilters($queryParams);

        if (!$errorsAndFilters) {
            return null;
        }

        $errors = $errorsAndFilters[0];
        $filters = $errorsAndFilters[1];

        if (!count($errors)) {
            return $filters;
        }

        echo $this->jsonConverter->convertArrayToJson(["errors" => $errors]);
        exit;
    }
}
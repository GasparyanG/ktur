<?php
namespace BusinessLogic\PostActions;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use Augmention\Convertion\JsonConverter as JsonConverter;
use Validation\Validator as Validator;
use BusinessLogic\PostActions\ValidationProductFactory\Factory as Factory;
use BusinessLogic\PostActions\TableCreation\Factory as TableCreationFactory;
use BusinessLogic\StatementPortions\Supplier;

class PostActions
{
    public function __construct()
    {
        $this->clientSideData = [
            'statement-addition' => 'Statement Addition',
        ];

        $this->configFetcher = new ConfigFetcher();
        $this->jsonConverter = new JsonConverter();
        $this->factory = new Factory();
        $this->tableCreationFactory = new TableCreationFactory();
        $this->supplier = new Supplier();
    }

    public function getStatementAddition($req, $res, $routeInfo)
    {
        $res->render("/user/post-actions/statement/add-statement.html", ["title" => $this->clientSideData['statement-addition']]);
    }

    public function fetchStatementAdditionInfo($req, $res, $routeInfo)
    {
        echo $this->supplier->fetchStatementAdditionInfo();
    }

    public function postAction($req, $res, $routeInfo)
    {
        // objects to rely on
        $validator = new Validator();

        $parsedBodyInJsonFormat = $req->getParsedBody();

        $jsonFromCleintConvertedToArray = $this->jsonConverter->jsonDecodeWithFileGetContents();

        foreach($jsonFromCleintConvertedToArray as $statementType => $formBody) {
            // one way to fetch key and value from assoc array
        }

        foreach($formBody as $fieldName => $fieldValue) {
            // $validator will store all error messages:
            // $validator->getErrorMessages();
            $this->factory->validate($fieldName, $fieldValue, $validator);
        }

        $errorMessages = $validator->getErrorMessages();

        if ($errorMessages) {
            echo $this->jsonConverter->convertArrayToJson($errorMessages);
            exit;
        }

        // create table and make corresponding insertions!
        $indHouseId = $this->tableCreationFactory->makeRecord($statementType, $formBody, $routeInfo);
        
        $clientRedirection = $this->configFetcher->fetchConf('URI_CONFIG', ['redirection', 'client_redirection']);
        $indHouseStatementUri = $this->configFetcher->fetchConf("URI_CONFIG", ['uri_pathes', 'ind-house-statement']);
        $keyValueForRedirection = [$clientRedirection => $indHouseStatementUri . "/" . $indHouseId];

        echo $this->jsonConverter->convertArrayToJson($keyValueForRedirection);
    }
}
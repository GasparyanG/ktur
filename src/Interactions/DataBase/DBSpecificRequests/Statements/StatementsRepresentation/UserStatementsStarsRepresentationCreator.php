<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation;

use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use DataBase\Implementations\DBManipulator as DBManipulator;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class UserStatementsStarsRepresentationCreator
{
    public function __construct()
    {
        $this->amountOfStarsKey = "amount_of_stars";

        $this->amountOfStatements = 10;

        $this->jsonPrepareness = new JsonPrepareness();
        $this->configFetcher = new ConfigFetcher();
        $this->dbmanipulator = new DBManipulator();

        $this->statementsInfoPreparerDirNamespace = "DataBase\DBSpecificRequests\Statements\StatementsRepresentation\StarsRepresentation\\";
        $this->statementTypes = [
            "ind_house" => "IndHouseStarsRepresentation"
        ];

        // supporter has all required objects to construct desired data sructure
        $this->supporter = null;
    }

    public function getStatementsResources(array $offSetArray, string $username, string $statementType = null, string $filter): array
    {
        $arrayOfStatementsInfo = [];
        $this->changeStatementTypes($statementType);
        
        foreach($this->statementTypes as $typeName => $statementsInfoPreparerName) {
            $offSetForCurrentStatementType = $this->getRequiredOffSet($offSetArray, $typeName);

            $fullyQualifiedNamespace = $this->statementsInfoPreparerDirNamespace . $statementsInfoPreparerName;
            $this->supporter = new $fullyQualifiedNamespace();
            
            $specificStarsTableDefinition = $this->supporter->starsTableDefinition();
            $uniqueIdentifierKey = $specificStarsTableDefinition->getUniqueIdentifierKey();

            $metadataStoringTableDefinition = $this->supporter->statementMetadataTableDefinition();
            
            $statementsUniqueIdentifiersArrays = $this->getStatementsUniqueIdentifiersArray($offSetForCurrentStatementType, $username, $specificStarsTableDefinition);
            $statementsInfo = $this->getStatementsInfo($statementsUniqueIdentifiersArrays, $uniqueIdentifierKey, $metadataStoringTableDefinition);

            $arrayOfMetadata = $this->getMetadataForClient($statementsInfo, $uniqueIdentifierKey, $specificStarsTableDefinition);

            $arrayOfStatementsInfo[$typeName] = $this->prepareStatementTypeArray($arrayOfMetadata, $uniqueIdentifierKey);
        }

        
        return $arrayOfStatementsInfo;
    }

    private function changeStatementTypes(string $statementType = null): void
    {
        // user may want to get concreate statement type representation
        if ($statementType) {

            $statementType = strtolower($statementType);
            
            if (!isset($this->statementTypes[$statementType])) {
                throw new \InvalidArgumentException("$statementType is not defined!");
            }
            
            $statementTypeImplementorName = $this->statementTypes[$statementType];
            
            $this->statementTypes = [$statementType => $statementTypeImplementorName];
        }
    }

    /**
     * return int from offsets array to pass to statement type data fetcher
     * 
     * @param array $offSetArray assoc array:
     *      [
     *          "statement-type" => int,
     *          "statement-type 1" => int
     *      ]
     * @param string $statementType is used to get offset from $offsetArray
     */
    private function getRequiredOffSet(array $offSetArray, string $statementType): int
    {
        if (!isset($offSetArray[$statementType])) {
            throw new \InvalidArgumentException("$statementType offsetarray is not defined!");
        }

        if (!is_numeric($offSetArray[$statementType])) {
            throw new \InvalidArgumentException("$offSetArray[$statementType] is not numeric value!");
        }

        return $offSetArray[$statementType];
    }

    private function getStatementsUniqueIdentifiersArray(int $offSetForCurrentStatementType, string $username, $specificStarsTableDefinition): array
    {
        // most stared statements will be returned first!
        $staredStatementsUniqueIdentifiersFetchingStatement = $specificStarsTableDefinition->
        getStaredStatementUniqueIdentiferFetchingStatement($offSetForCurrentStatementType, $this->amountOfStatements, $username);
        
        return $this->dbmanipulator->read($staredStatementsUniqueIdentifiersFetchingStatement, "A");
    }

    private function getStatementsInfo(array $statementsUniqueIdentifiersArrays, $uniqueIdentifierKey, $metadataStoringTableDefinition): array
    {
        $statementsInfo = [];
        foreach($statementsUniqueIdentifiersArrays as $uniqueIdentifierArray) {
            $uniqueIdentifier = $uniqueIdentifierArray[$uniqueIdentifierKey];
            $starsImportantDataReaderStatement = $metadataStoringTableDefinition->getStatementStarRequiredData($uniqueIdentifier);
            $statementsInfo[] = $this->dbmanipulator->read($starsImportantDataReaderStatement, "O");
        }

        return $statementsInfo;
    }

    private function getMetadataForClient(array $statementsInfo, string $uniqueIdentifierKey, $specificStarsTableDefinition): array
    {
        $arrayOfMetadata = [];
        // statement star count fetching
        foreach($statementsInfo as $statementInfo) {
            $statementUniqueIdentifier = $statementInfo[$uniqueIdentifierKey];
            $statementsOfCoutingStars = $specificStarsTableDefinition->countStarStatementPreparing($statementUniqueIdentifier);
            $statementStarsStoringArray = $this->dbmanipulator->read($statementsOfCoutingStars, "O");
            $statementStars = $statementStarsStoringArray[$uniqueIdentifierKey];
            $statementInfo[$this->amountOfStarsKey] = $statementStars;
            $arrayOfMetadata[] = $statementInfo;
        }

        return $arrayOfMetadata;
    }

    private function prepareStatementTypeArray(array $arrayOfMetadata, string $uniqueIdentifierKey): array
    {
        $data = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "data"]);
        $refer = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "refer"]);
        $action = $this->configFetcher->fetchConf("CLIENT_SERVER_CONFIG", ["statement_repr", "action"]);

        $statementTypeArray = [];

        foreach($arrayOfMetadata as $nestedArray) {
            $individualArray = [];
            $individualArray[$data] = $nestedArray;

            $uniqueIdentifier = $nestedArray[$uniqueIdentifierKey];
            $individualArray[$refer][] = $this->getSelfPointingInfo($uniqueIdentifier);
            $individualArray[$refer][] = $this->getImageInfo($uniqueIdentifier);

            $individualArray[$action][] = $this->getSeeStarsInfo($uniqueIdentifier);

            $statementTypeArray[] = $individualArray;
        }

        return $statementTypeArray;
    }

    private function getSelfPointingInfo($uniqueIdentifier): array
    {
        $uriPathPortion = $this->supporter->getSelfPointingUriSegment();
        $selfPointingUri = $uriPathPortion . "/$uniqueIdentifier";

        return $this->jsonPrepareness->makeHrefRestfull($selfPointingUri, "self");
    }

    private function getImageInfo($uniqueIdentifier): array
    {
        $statementsPhotosTableDefinition = $this->supporter->statementPhotosTableDefinition();
        $statementToGetFileName = $statementsPhotosTableDefinition->getFileNamesFetchingStatement($uniqueIdentifier);
        $keyAndImageFileName = $this->dbmanipulator->read($statementToGetFileName, "O");
        $fileName = $keyAndImageFileName["file_name"];

        $photoDir = $this->configFetcher->fetchConf("URI_CONFIG", ["photos", "statement_photos", "directory"]);
        $photoSrc = $photoDir . $fileName;

        return $this->jsonPrepareness->makeHrefRestfull($photoSrc, "image");
    }

    private function getSeeStarsInfo($uniqueIdentifier)
    {
        $uriPathPortion = $this->supporter->getSelfPointingUriSegment();
        $seeStarActionPathPortion = $this->configFetcher->fetchConf("URI_CONFIG", ["actions_over_statements", "see-stars"]);
        $actionUri = $uriPathPortion . "/" . $uniqueIdentifier . $seeStarActionPathPortion;

        return $this->jsonPrepareness->makeHrefRestfull($actionUri, "see-stars");
    }
}
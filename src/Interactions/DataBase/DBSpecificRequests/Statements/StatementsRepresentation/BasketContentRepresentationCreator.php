<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation;

class BasketContentRepresentationCreator
{
    public function __construct()
    {
        $this->statementsInfoPreparerDirNamespace = "DataBase\DBSpecificRequests\Statements\StatementsRepresentation\BasketRepresentationCreators\\";
        $this->statementTypes = [
            "ind_house" => "IndHouseRepresentationCreator"
        ];
    }

    /**
     * username can't be null because basket belongs to concreate user
     */
    public function getStatementsResources(array $offSetArray, string $username, string $statementType = null, $filter): array
    {
        // array to be retunred
        $arrayOfStatementsInfo = [];
        $this->changeStatementTypes($statementType);
        
        foreach($this->statementTypes as $typeName => $statementsInfoPreparerName) {
            $offSetForCurrentStatementType = $this->getRequiredOffSet($offSetArray, $typeName);

            $fullyQualifiedNamespace = $this->statementsInfoPreparerDirNamespace . $statementsInfoPreparerName;
            $statementsInfoPreparer = new $fullyQualifiedNamespace();
            $preparedData = $statementsInfoPreparer->prepareData($offSetForCurrentStatementType, $username, $filter);
            $arrayOfStatementsInfo[$typeName] = $preparedData;
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

}
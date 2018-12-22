<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation;

class StatementsRepresentationCreator
{
    public function __construct()
    {
        $this->statementsInfoPreparerDirNamespace = // create direcotry and define below written objects!
        $this->statementTypes = [
            "ind_house" => "IndHouseRepresentaionCreator"
        ];
    }

    /**
     * create data structure full of statemtn's info and return
     * 
     * @param array $offSetArray contains offsets of every table that needed to be included into result of this function:
     *      all statements will not be returned only some of them, but if user wants to see more then oportunity will
     *      be given: next set of statements will be returned based on this offset array !
     * @param string|null $username for user's statements request from database:
     *      if username is not defined i.e. equals to null then all of table's rows is required !
     * @param string $statementType if concrete statement's type is needed then this param will help !
     * 
     * @return array
     */
    public function getStatementsResources(array $offSetArray, string $username = null, string $statementType = null): array
    {
        $arrayOfStatementsInfo = [];

        if (!$username) {
            // soon
        }

        $this->changeStatementTypes($statementType);
        foreach($this->statementTypes as $typeName => $statementsInfoPreparerName) {
            $fullyQualifiedNamespace = $this->statementsInfoPreparerDirNamespace . $statementsInfoPreparerName;
            $statementsInfoPreparer = new $fullyQualifiedNamespace();
            $preparedData = $statementsInfoPreparer->prepareData($offSetArray, $username, $typeName);
            $arrayOfStatementsInfo[$typeName] = $preparedData;
        }

        return $arrayOfStatementsInfo;
    }

    private function changeStatementTypes(string $statementType): void
    {
        $statementType = strtolower($statementType);

        if (!isset($this->statementTypes[$statementType])) {
            throw new \InvalidArgumentException("$statementType is not defined!");
        }

        $statementTypeImplementorName = $this->statementTypes[$statementType];

        $this->statementTypes = [$statementType => $statementTypeImplementorName];
    }
}
<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation;

class StatementsRepresentationCreator
{
    public function __construct()
    {
        $this->statementsInfoPreparerDirNamespace = "DataBase\DBSpecificRequests\Statements\StatementsRepresentation\RepresentationCreators\\";
        $this->statementTypes = [
            "ind_house" => "IndHouseRepresentationCreator"
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
     * @param string $filter based on this query result will be more flexible !
     * 
     * @return array
     */
    public function getStatementsResources(array $offSetArray, string $username = null, string $statementType = null, string $filter): array
    {
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

    /**
     * prepare username for SQL LIKE constraint:
     *  "SELECT * FROM tableName WHERE username like (some string either '%' or username)" 
     *  
     * - % sign is the same as select all usernames
     * - username will force SQL to only return columns, which is matching to passed in username
     * 
     * @param string|null $username
     * 
     * @return string
     */
    private function prepareUsernameForLikeConstraint(string $username = null): string
    {
        // username === null
        if (!$username) {
            $username = "%";
        }

        return $username;
    }
}
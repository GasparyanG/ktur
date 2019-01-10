<?php
namespace ClientSideGuru\QueryStringParamsPreparing;

class QueryParamsPreparer
{
    // diff statement type offsets ment for data retriving from database
    protected $offSetsArray;
    // filter
    protected $filter;
    // statement type
    protected $statementType;

    /**
     * to set all proprties based on passed in array its important to know client side seted keys
     */
    public function __construct(array $queryParams)
    {
        $this->offSetKeys = [
            // ind-house-offset is from client side
            "ind_house" => "ind-house-offset",
        ];

        $this->clientSideSetedKeys = [
            "filter" => "filter",
            "statementType" => "statement-type",
        ];

        $this->defaultValues = [
            "filter" => "regular",
            "statementType" => null,
        ];

        $this->offSetsArray = $this->setOffsetsArray($queryParams);
        $this->filter = $this->setFilter($queryParams);
        $this->statementType = $this->setStatementType($queryParams);
    }

    private function setOffsetsArray($queryParams): array
    {
        $offSetsArray = [];
        foreach($this->offSetKeys as $key => $value) {
            if (isset($queryParams[$value])) {
                $offSetsArray[$key] = $queryParams[$value];
            }
        }

        if (count($offSetsArray) === 0) {
            throw new \LengthException("given array need to have element(s) inside");
        }

        return $offSetsArray;
    }

    private function setFilter($queryParams)
    {
        if (isset($queryParams[$this->clientSideSetedKeys["filter"]])) {
            return $queryParams[$this->clientSideSetedKeys["filter"]];
        }

        return $this->defaultValues["filter"];
    }

    // retrun string or null
    private function setStatementType($queryParams)
    {
        if (isset($queryParams[$this->clientSideSetedKeys["statementType"]])) {
            return $queryParams[$this->clientSideSetedKeys["statementType"]];
        }

        // returnes null
        return $this->defaultValues["statementType"];
    }

    public function getOffSetsArray(): array
    {
        return $this->offSetsArray;
    }

    public function getFilter():string
    {
        return $this->filter;
    }

    public function getStatementType()
    {
        return $this->statementType;
    }
}
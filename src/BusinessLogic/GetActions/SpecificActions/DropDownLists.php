<?php
namespace BusinessLogic\GetActions\SpecificActions;

use BusinessLogic\StatementPortions\Supplier;

class DropDownLists
{
    public function __construct()
    {
        $this->supplier = new Supplier();
    }

    public function getLists($req, $res, $routeInfo)
    {
        echo $this->supplier->fetchStatementAdditionInfo();
    }
}
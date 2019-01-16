<?php
namespace BusinessLogic\PostActions\Comment\Products;

use DataBase\Tables\IndHouseComments;
use DataBase\Implementations\DBManipulator;

class IndHouse
{
    public function __construct()
    {
        $this->indHouseComments = new IndHouseComments();
        $this->dbmanipulator = new DBManipulator();
    }

    public function isUsed(string $statementType): bool
    {
        return $statementType === "ind-houses";
    }

    public function addComment(string $uniqueIdenitifier, string $username, string $comment)
    {
        // validation is one of the vial part of data additionto db

        /**
         * [x] table creation
         * [x] statement addition
         */

        // table creation
        $tableCreationStatement = $this->indHouseComments->getTableDef();
        $this->dbmanipulator->create($tableCreationStatement, "T");

        // row insertion
        $rowInsertionStatement = $this->indHouseComments->getCommentAdditionStatement($uniqueIdenitifier, $username, $comment);
        $this->dbmanipulator->create($rowInsertionStatement, "R");

        return true;
    }
}
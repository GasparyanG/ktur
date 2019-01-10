<?php
namespace DataBase\DBSpecificRequests\User;

use DataBase\Implementations\DBmanipulator as DBManipulator;

class UserDataFetcher
{
    public function __construct()
    {
        $this->dbmanipulator = new DBManipulator();
    }

    /**
     * fetch image file name from database appropriate table!
     */
    public function fetchImageFileName(string $username)
    {
        $statement = "SELECT user_image FROM user_components WHERE username = \"$username\"";
        $dataFromDataBase = $this->dbmanipulator->read($statement, "O");

        return $dataFromDataBase;
    }
}
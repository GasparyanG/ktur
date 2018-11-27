<?php
namespace BusinessLogic\PageObjects;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use DataBase\Implementations\DBManipulator as DBManipulator;

class Home
{
    public function getHome($req, $plHol)
    {
        $dbmanipulator = new DBManipulator();

        $statement = "SELECT * FROM users";

        $queryResult = $dbmanipulator->read($statement, "A");

        echo "<pre>";
        var_dump($queryResult);

        $configFetcher = new ConfigFetcher();

        $value = $configFetcher->fetchConf('DATABASE_CONFIG', ['DB1','username']);

        if (!$value) {
            echo "false";
        }

        echo $value;


    }
}
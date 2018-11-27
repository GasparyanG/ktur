<?php
namespace DataBase\Config;

use Interactions\Config\ConfigFetcher as ConfigFetcher;
use PDO;

class Connection
{
    public function __construct()
    {
        $configFetcher = new ConfigFetcher();
        
        $serverName = $configFetcher->fetchConf('DATABASE_CONFIG', ['DB1', 'serverName']);
        $dbName     = $configFetcher->fetchConf('DATABASE_CONFIG', ['DB1', 'dbName']);
        $userName   = $configFetcher->fetchConf('DATABASE_CONFIG', ['DB1', 'userName']);
        $password   = $configFetcher->fetchConf('DATABASE_CONFIG', ['DB1', 'password']);

        try
        {
            $conn = new PDO("mysql:host=" . $serverName . ";dbname=" . $dbName,
            $userName, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
        
        $this->conn = $conn;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
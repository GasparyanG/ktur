<?php
namespace BusinessLogic\PageObjects;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class Home
{
    public function getHome($req, $plHol)
    {
        $configFetcher = new ConfigFetcher();

        $value = $configFetcher->fetchConf('DATABASE_CONFIG', ['DB1','username']);

        if (!$value) {
            echo "false";
        }

        echo $value;
    }
}
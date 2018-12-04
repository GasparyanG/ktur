<?php
namespace Interactions\Config;

class ConfigFetcher
{
    private $rootPath;
    private $appConf;

    public function __construct()
    {
        $this->rootPath = __DIR__ . "/../../../config";

        /**
         * @property string[] configuration array array name of corresponding conf 
         *      maped with it's path!
         */
        $this->appConf = [
            "DATABASE_CONFIG"   => "/db/mapping.php",
            "COOKIE_CONFIG"     => "/cookie/mapping.php",
            "HASH_CONFIG"       => "/hashing/mapping.php",
            "URI_CONFIG"        => "/uri/mapping.php",
        ];
    }

    public function fetchConf(string $arrayName, array $keysToValue)
    {
        $upperName = strtoupper($arrayName);

        $confPath = $this->getConfPath($upperName);

        if (!$confPath) {
            return false;
        }

        require $this->rootPath . $confPath;

        $configArray = $$upperName;

        $value = $this->fetchValue($configArray, $keysToValue);

        if (!$value) {
            return false;
        }

        return $value;
    }

    private function getConfPath(string $upperName): string
    {
        if (isset($this->appConf[$upperName])) {
            $confPath = $this->appConf[$upperName];

            // if string don't have php extension then append
            if (!preg_match("~.*.php~",$confPath, $matches)) {
                $confPath = $confPath . ".php";
            }

            return $confPath;
        }

        return false;
    }

    private function fetchValue(array $configArray, array $keysToValue)
    {
        foreach($keysToValue as $keyToValue) {
            if (!isset($configArray[$keyToValue])) {
                return false;
            }

            // desired value will be holden by $configArray!
            $configArray = $configArray[$keyToValue];
        }

        return $configArray;
    }
}
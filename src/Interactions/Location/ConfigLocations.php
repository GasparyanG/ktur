<?php
namespace Interactions\Location;

use Interactions\Location\LocationInterface as LocationInterface;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class ConfigLocations implements LocationInterface
{
    public function __construct()
    {
        // object to rely on
        $this->configFetcher = new ConfigFetcher();

        $this->locationKeyWord = "locations";
    }

    public function getLocations()
    {
        $arrayForLocations = [];
        $locations = $this->configFetcher->fetchConf("OPTIONS_CONFIG", ["locations"]);
        $arrayForLocations[$this->locationKeyWord] = $locations;

        return $arrayForLocations;
    }
}
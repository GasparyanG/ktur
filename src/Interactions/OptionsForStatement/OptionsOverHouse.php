<?php
namespace Interactions\OptionsForStatement;

use Interactions\OptionsForStatement\OptionsInterface as Optionsinterface;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class OptionsOverHouse implements OptionsInterface
{
    public function __construct()
    {
        // objects to rely on
        $this->configFetcher = new ConfigFetcher();
        
        $this->optionsForHouse = "houseOptions";
    }

    public function getOptions()
    {
        $assocArrayForHouseOptions = [];
        $options = $this->configFetcher->fetchConf("OPTIONS_CONFIG", ["house"]);
        $assocArrayForHouseOptions[$this->optionsForHouse] = $options;

        return $assocArrayForHouseOptions;
    }
}
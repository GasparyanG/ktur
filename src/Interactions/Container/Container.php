<?php
namespace Interactions\Container;

class Container
{
    public function __construct()
    {
        $this->objectNamespaces = [
            "locations" => "Interactions\Location\ConfigLocations",
            "houseoptions" => "Interactions\OptionsForStatement\OptionsOverHouse",
        ];

        $this->objectMethodNames = [
            "locations" => "getLocations",
            "houseoptions" => "getOptions",
        ];
    }

    public function fetchData(string $fetcherName, array $assocArray = null)
    {
        $lowerCaseFetcherName = strtolower($fetcherName);

        $this->validFetcherName($lowerCaseFetcherName);

        $objectNamespace = $this->objectNamespaces[$lowerCaseFetcherName];
        $instantiatedObject = new $objectNamespace();

        $methodOfDesiredObjectName = $this->objectMethodNames[$lowerCaseFetcherName];

        $fetchedAssocArray =  $instantiatedObject->$methodOfDesiredObjectName();

        if ($assocArray) {
            foreach($fetchedAssocArray as $key => $value) {
                $assocArray[$key] = $value;
            }

            return $assocArray;
        }

        return $fetchedAssocArray;
    }

    private function validFetcherName($lowerCaseFetcherName)
    {
        if (!isset($this->objectNamespaces[$lowerCaseFetcherName])) {
            throw new \InvalidArgumentException("$lowerCaseFetcherName does not located in objectNamespaces array");
        }
    }
}
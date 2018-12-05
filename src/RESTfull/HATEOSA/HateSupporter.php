<?php
namespace RESTfull\HATEOSA;

use Interactions\Config\ConfigFetcher as ConfigFetcher;

class HateSupporter
{   
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
    }
    
    public function combinePathSegments(array $keysToPath, string $fileName = null): string
    {
        $pathSegment = $this->configFetcher->fetchConf("URI_CONFIG", $keysToPath);

        if (!$fileName) {
            // this also is ment to be full path!
            return $pathSegment;
        }

        if ($this->validatePathSegment($pathSegment)) {
            $fullPath = $pathSegment . $fileName;
            return $fullPath;
        }
    }

    private function validatePathSegment($pathSegment)
    {
        if (substr($pathSegment, -1) === "/") {
            return true;
        }

        throw new InvalidArgumentException("Passed argument MUST have '/' caracter at the end of the string:
         /config/uri/mapping.php" . $pathSegment);
    }
}
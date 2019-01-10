<?php
namespace RESTfull\HATEOSA;

use Interactions\Config\ConfigFetcher as ConfigFetcher;

class HateSupporter
{   
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
    }
    
    public function combinePathSegments(array $keysToPath, string $fileName = null, $reverced = false): string
    {
        $pathSegment = $this->getPathSegmentFromConfig($keysToPath);

        if (!$fileName) {
            // this also is ment to be full path!
            return $pathSegment;
        }

        if ($reverced) {
            $pathSegment = $this->removeTrailingSlash($pathSegment);

            $fullPath = "/" . $fileName . "/" . $pathSegment;
            return $fullPath;
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

        throw new \InvalidArgumentException("Passed argument MUST have '/' caracter at the end of the string:
         /config/uri/mapping.php" . $pathSegment);
    }

    private function getPathSegmentFromConfig($keysToPath)
    {
        $pathSegment = $this->configFetcher->fetchConf("URI_CONFIG", $keysToPath);

        return $pathSegment;
    }

    private function removeTrailingSlash(string $pathSegment): string
    {
        if (substr($pathSegment, -1) === "/") {
            $pathSegment = substr_replace($pathSegment, "", -1);

            return $pathSegment;
        }
    }
}
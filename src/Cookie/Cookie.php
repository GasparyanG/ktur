<?php
namespace Cookie;

use Interactions\Config\ConfigFetcher as ConfigFetcher;

class Cookie
{
    /**
     * user portion of propertie/variable defineition is convenient
     * because as soon as app will be scaled new type of usage will be offerde to end user
     * by adding or subtracting new privelagies 
     */
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();

        $this->userExpireDate = $this->getUserExpireDate();
        $this->userAppTraversePath = $this->getUserAppTraversePath();
    }

    public function setCookie(string $cookieName, $cookieValue)
    {
        setcookie($cookieName, $cookieValue, $this->userExpireDate, $this->userAppTraversePath);
    }

    private function getUserExpireDate()
    {
        $currentTime = time();

        $amountOfTime = $this->configFetcher->fetchConf("COOKIE_CONFIG", ["user", "expire"]);
        $expireDate = $currentTime + $amountOfTime;

        return $expireDate;
    }

    private function getUserAppTraversePath()
    {
        return $this->configFetcher->fetchConf("COOKIE_CONFIG", ["user", "path"]);
    }
}
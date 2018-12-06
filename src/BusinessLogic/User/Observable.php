<?php
namespace BusinessLogic\User;

use Interactions\Config\ConfigFetcher as ConfigFetcher;

class Observable
{
    public function __construct()
    {
        $this->configFetcher = new ConfigFetcher();
    }

    public function isAuthenticated(array $cookieParams): bool
    {
        $userResourceCookieName = $this->configFetcher->fetchConf("COOKIE_CONFIG", ['cookie_names', 'user_resource']);

        if (!isset($cookieParams[$userResourceCookieName])) {
            return false;
        }

        return true;
    }
}
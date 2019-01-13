<?php
namespace BusinessLogic\NavBar;

use BusinessLogic\User\Observable as Observable;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use DataBase\DBSpecificRequests\User\UserDataFetcher as UserDataFetcher;
use Augmention\Convertion\JsonConverter as JsonConverter;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use RESTfull\HATEOSA\HateSupporter as HateSupporter;

class NavBar
{
    public function __construct()
    {
        $this->observable = new Observable();
        $this->configFetcher = new ConfigFetcher();
        $this->userDataFetcher = new UserDataFetcher();
        $this->jsonConverter = new JsonConverter();
        $this->jsonPrepareness = new JsonPrepareness();
        $this->hateSupporter = new HateSupporter();
    }

    public function populateNavBar($req, $res, $routeInfo)
    {
        $cookieParams = $req->getCookieParams();

        $isAuthenticated = $this->observable->isAuthenticated($cookieParams);

        if ($isAuthenticated) {
            $userResourceCookieName = $this->configFetcher->fetchConf("COOKIE_CONFIG", ['cookie_names', 'user_resource']);
            $userResourceCookieValue = $cookieParams[$userResourceCookieName];

            $dataInJsonFormat = $this->getDataForAuthenticatedUser($userResourceCookieValue);

            echo $dataInJsonFormat;
        }

        else {
            $dataInJsonFormat = $this->getDataForNotAuthenticatedUser();

            echo $dataInJsonFormat;
        }
    }

    private function getDataForAuthenticatedUser($userResourceCookieValue)
    {
        $dataForAuthenticatedUser = [];
        
        $userDir = "/$userResourceCookieValue";
        
        // drop down links preparing
        // statements
        $statementsUri = $this->hateSupporter->combinePathSegments(["actions", "get-actions", "statements"], $userResourceCookieValue, true);
        $statementsHReady = $this->jsonPrepareness->makeHrefRestfull($statementsUri, "statements");
        $dataForAuthenticatedUser['authenticated'][] = $statementsHReady;
        // basket
        $basketUri = $this->hateSupporter->combinePathSegments(["actions", "get-actions", "basket"], $userResourceCookieValue, true);
        $basketHReady = $this->jsonPrepareness->makeHrefRestfull($basketUri, "basket");
        $dataForAuthenticatedUser['authenticated'][] = $basketHReady;
        // statement addtion
        $statementAdditionUri = $this->hateSupporter->combinePathSegments(["actions", "post-actions", "add-statement"], $userResourceCookieValue, true);
        $statementAdditionHReady = $this->jsonPrepareness->makeHrefRestfull($statementAdditionUri, "statement-addition");
        $dataForAuthenticatedUser['authenticated'][] = $statementAdditionHReady;
        // stars
        $starsUri = $this->hateSupporter->combinePathSegments(["actions", "get-actions", "stars"], $userResourceCookieValue, true);
        $starsHReady = $this->jsonPrepareness->makeHrefRestfull($starsUri, "stars");
        $dataForAuthenticatedUser['authenticated'][] = $starsHReady;
        
        $userImageFileName = $this->userDataFetcher->fetchImageFileName($userResourceCookieValue);
        $userDefaultImageServingPath = $this->hateSupporter->combinePathSegments(['photos', 'user', 'default'], $userImageFileName['user_image']);

        $jsonPreparedHrefAndRel = $this->jsonPrepareness->makeHrefRestfull($userDefaultImageServingPath, "user_image", $userDir);
        // prepare links this way and pass to clinet side by including into $dataForAuthenticatedUser array and converting to json
        
        /**
         * {authenticated:[0,:[
         *    href:"path/to/somewhere",
         *    rel:"relationship with sth"
         * ],
         * ]}
         */
        $dataForAuthenticatedUser['authenticated'][] = $jsonPreparedHrefAndRel;

        $jsonConverted = $this->jsonConverter->convertArrayToJson($dataForAuthenticatedUser);

        return $jsonConverted;
    }

    private function getDataForNotAuthenticatedUser()
    {
        $dataForUnAuthenticatedUser = [];

        $signUpPath = $this->configFetcher->fetchConf('URI_CONFIG', ['uri_pathes', 'sign-up']);
        $jsonPreparedHrefAndRelForSignUp = $this->jsonPrepareness->makeHrefRestfull($signUpPath, "sign-up");
        
        $logInPath = $this->configFetcher->fetchConf('URI_CONFIG', ['uri_pathes', 'log-in']);
        $jsonPreparedHrefAndRelForLogIn = $this->jsonPrepareness->makeHrefRestfull($logInPath, "log-in");

        $arrayOfData = [$jsonPreparedHrefAndRelForSignUp, $jsonPreparedHrefAndRelForLogIn];

        foreach($arrayOfData as $data) {
            $dataForUnAuthenticatedUser['un_authenticated'][] = $data;
        }

        $jsonConverted = $this->jsonConverter->convertArrayToJson($dataForUnAuthenticatedUser);

        return $jsonConverted;
    }
}
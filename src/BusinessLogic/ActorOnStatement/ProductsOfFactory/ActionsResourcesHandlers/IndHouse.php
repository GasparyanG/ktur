<?php
namespace BusinessLogic\ActorOnStatement\ProductsOfFactory\ActionsResourcesHandlers;

use DataBase\Tables\IndHouseStar;
use DataBase\Tables\IndHouseComments;
use DataBase\Tables\IndHouseBasket;
use RESTfull\SpecificImplementations\ActionsOverStatement\HATEOASReady;
use Interactions\Config\ConfigFetcher;

class IndHouse
{
    public function __construct($dbmanipulator, $configFetcher) 
    {
        $this->configFetcher = $configFetcher;
        $this->dbmanipulator = $dbmanipulator;

        $this->indHouseStar = new IndHouseStar();
        $this->indHouseComments = new IndHouseComments();
        $this->indHouseBasket = new IndHouseBasket();
        $this->hready = new HATEOASReady();
        $this->configFetcher = new ConfigFetcher();

        $this->indHouseTableName = $this->configFetcher->fetchConf("DATABASE_CONFIG", ["DB1", "tables", "ind_house_statements"]);
    }

    public function isUsed(string $statementType): bool
    {
        return $statementType === "ind-houses";
    }

    public function getActionsResources($username, $uniqueIdentifier): array
    {
        $arrayToReturn = [];

        // star data:
        // user state of star, amount of star
        $arrayToReturn["star_data"] = $this->getStarData($username, $uniqueIdentifier);
        // comment data
        // user state of comment, amount of comments
        $arrayToReturn["comment_data"] = $this->getCommentData($username, $uniqueIdentifier);
        // basket data
        // user state of basket, amount of forks (adding statement to basket)
        $arrayToReturn["basket_data"] = $this->getBasketData($username, $uniqueIdentifier);

        return $arrayToReturn;
    }

    public function getStarData($username, $uniqueIdentifier)
    {
        if (!$this->dbmanipulator->tableExists("ind_house_stars")) {
            return null;
        }

        $amountOfStarsStatement = $this->indHouseStar->starsAmountStatement($uniqueIdentifier);
        $amountOfStars = $this->dbmanipulator->read($amountOfStarsStatement, "O");
        
        $userStarStateStatement = $this->indHouseStar->checkUserStarState($uniqueIdentifier, $username);
        $userState = $this->dbmanipulator->read($userStarStateStatement, "O");
        $amountOfStars["user_star_state"] = count($userState) > 0 && $userState != false ? true : false;
        $amountOfStars["className"] = $this->hready->getStar($this->indHouseTableName, $uniqueIdentifier);

        return $amountOfStars;
    }

    public function getCommentData($username, $uniqueIdentifier)
    {
        if (!$this->dbmanipulator->tableExists("ind_house_comments")) {
            return null;
        }

        $amountOfCommentsStatement = $this->indHouseComments->getAmountOfCommentsStatement($uniqueIdentifier);
        $amountOfComments = $this->dbmanipulator->read($amountOfCommentsStatement, "O");

        $userCommentStatement = $this->indHouseComments->userCommentStatement($uniqueIdentifier, $username);
        $userState = $this->dbmanipulator->read($userCommentStatement, "O");
        $amountOfComments["user_comment_state"] = count($userState) > 0 && $userState != false ? true : false;
        $amountOfComments["className"] = $this->hready->getcomment($this->indHouseTableName, $uniqueIdentifier);

        return $amountOfComments;
    }

    public function getBasketData($username, $uniqueIdentifier)
    {
        if (!$this->dbmanipulator->tableExists("ind_house_basket")) {
            return null;
        }

        $amountOfForksStatement = $this->indHouseBasket->getAmountOfForkedStatement($uniqueIdentifier);
        $amountOfForks = $this->dbmanipulator->read($amountOfForksStatement, "O");

        $userForkStateStatement = $this->indHouseBasket->checkUserBasketState($uniqueIdentifier, $username);
        $userForkState = $this->dbmanipulator->read($userForkStateStatement, "O");
        $amountOfForks["user_fork_state"] = count($userForkState) > 0 && $userForkState != false ? true : false;
        $amountOfForks["className"] = $this->hready->getbasket($this->indHouseTableName, $uniqueIdentifier);

        return $amountOfForks;
    }
}
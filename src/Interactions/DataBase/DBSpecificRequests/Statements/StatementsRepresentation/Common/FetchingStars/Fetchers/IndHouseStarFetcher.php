<?php
namespace DataBase\DBSpecificRequests\Statements\StatementsRepresentation\Common\FetchingStars\Fetchers;

use DataBase\Tables\IndHouseStar;
use DataBase\Implementations\DBManipulator;

class IndHouseStarFetcher
{
    public function __construct()
    {
        $this->indHouseIdKey = "ind_house_id";
        $this->indHouseStar = new IndHouseStar();
        $this->dbmanipulator = new DBManipulator();
    }

    public function stars($nestedArray)
    {
        $indHouseId = $nestedArray[$this->indHouseIdKey];
        $statement = $this->indHouseStar->starsAmountStatement($indHouseId);

        $amountOfStars = $this->dbmanipulator->read($statement, "O");
        
        return $amountOfStars["amount_of_stars"];
    }

    public function isLiked($nestedArray, $username)
    {
        $indHouseId = $nestedArray[$this->indHouseIdKey];
        $statement = $this->indHouseStar->checkUserStarState($indHouseId, $username);

        $isStared = $this->dbmanipulator->read($statement, "O");

        if ($isStared) {
            return true;
        }

        return false;
    }
}
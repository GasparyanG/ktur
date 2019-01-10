<?php
namespace ClientSideGuru\QueryStringInteraction;

class GettingQueryStringValues
{
    public function __construct($arrayOfFilters)
    {
        $this->arrayOfFilters= $arrayOfFilters;
    }

    public function getLocation()
    {
        return $this->arrayOfFilters["location"];
    }

    public function getRentSell()
    {
        return $this->arrayOfFilters["rentSell"];
    }

    public function getMinPrice()
    {
        return $this->arrayOfFilters["min_price"];
    }

    public function getMaxPrice()
    {
        return $this->arrayOfFilters["max_price"];
    }
}
<?php
namespace ClientSideGuru\QueryStringParamsPreparing;

use Validation\Validator;

class FiltersInQueryString
{
    private $keysOfFilters;

    public function __construct()
    {
        $this->valueNotSeted = "undefined";

        // compare with client side definiton
        $this->keysOfFilters = [
            "location" => "location",
            "rentSell" => "rentSell",
            "minPrice" => "min_price",
            "maxPrice" => "max_price"
        ];

        $this->filtersDefaults = [
            "location" => "%",
            "rentSell" => "%",
            "minPrice" => 0,
            "maxPrice" => 10000000
        ];

        $this->validator = new Validator();
        $this->filtersArray = [];
    }

    public function getFilters(array $queryParams): ?array
    {
        if (!$this->isSeted($queryParams)) {
            return null;
        }

        $this->validateLocation($queryParams);
        $this->validateRentSell($queryParams);
        $this->validateMinAndMaxPrice($queryParams);

        $errors = $this->validator->getErrorMessages();

        return [$errors, $this->filtersArray];
    }

    private function validateLocation(array $queryParams): void
    {
        if ($queryParams[$this->keysOfFilters["location"]] === $this->valueNotSeted) {
            $this->filtersArray[$this->keysOfFilters["location"]] = $this->filtersDefaults["location"];
        }

        else {
            $this->filtersArray[$this->keysOfFilters["location"]] = $queryParams[$this->keysOfFilters["location"]];
        }
    }

    private function validateRentSell($queryParams): void
    {
        if ($queryParams[$this->keysOfFilters["rentSell"]] === $this->valueNotSeted) {
            $this->filtersArray[$this->keysOfFilters["rentSell"]] = $this->filtersDefaults["rentSell"];
        }

        else {
            $this->filtersArray[$this->keysOfFilters["rentSell"]] = $queryParams[$this->keysOfFilters["rentSell"]];
        }
    }

    private function validateMinAndMaxPrice($queryParams): void
    {
        $minPrice = $queryParams[$this->keysOfFilters["minPrice"]];
        $maxPrice = $queryParams[$this->keysOfFilters["maxPrice"]];

        if ($minPrice === $this->valueNotSeted) {
            $this->filtersArray[$this->keysOfFilters["minPrice"]] = $this->filtersDefaults["minPrice"];
        }

        else {
            $this->filtersArray[$this->keysOfFilters["minPrice"]] = $minPrice;
        }

        if ($maxPrice === $this->valueNotSeted) {
            $this->filtersArray[$this->keysOfFilters["maxPrice"]] = $this->filtersDefaults["maxPrice"];
        }

        else {
            $this->filtersArray[$this->keysOfFilters["maxPrice"]] = $maxPrice;
        }

        $this->validator->isNumeric($this->keysOfFilters["minPrice"], $minPrice);
        $this->validator->isNumeric($this->keysOfFilters["maxPrice"], $maxPrice);

        if (is_numeric($minPrice) && is_numeric($maxPrice)) {
            $this->validator->greaterThan($minPrice, $maxPrice);
        }
    }

    private function isSeted($queryParams): bool
    {
        if (isset($queryParams[$this->keysOfFilters["minPrice"]]) && isset($queryParams[$this->keysOfFilters["maxPrice"]])
         && isset($queryParams[$this->keysOfFilters["location"]]) && isset($queryParams[$this->keysOfFilters["rentSell"]])) {
            return true;
        }

        return false;
    }
}
<?php
namespace ClientSideGuru\Statement;

use Augmention\Convertion\JsonConverter as JsonConverter;

class ConstraintFetcher
{
    public function __construct()
    {
        $this->jsonConverter = new JsonConverter();
    }

    public function getClientSideData()
    {
        $decodedDataFromClient = $this->jsonConverter->jsonDecodeWithFileGetContents();
        return $decodedDataFromClient;
    }

    public function getArrayOfOffsets()
    {
        $decodedDataFromClient = $this->getClientSideData();

        if (isset($decodedDataFromClient["statementOffsets"])) {
            $arrayOfOffSets = $decodedDataFromClient["statementOffsets"];
        }

        else {
            throw new \InvalidArgumentException("statementOffsets need to be defined in clinet side!");
        }

        return $decodedDataFromClient["statementOffsets"];
    }

    public function getStatementType()
    {
        $decodedDataFromClient = $this->getClientSideData();

        if (isset($decodedDataFromClient["statementType"])) {
            return $decodedDataFromClient["statementType"];
        }

        return null;
    }

    public function getFilter(): string
    {
        $decodedDataFromClient = $this->getClientSideData();

        if (isset($decodedDataFromClient["filter"])) {
            return $decodedDataFromClient["filter"];
        }

        throw new \InvalidArgumentException("filter is needed to be defind in client side!");
    }
}
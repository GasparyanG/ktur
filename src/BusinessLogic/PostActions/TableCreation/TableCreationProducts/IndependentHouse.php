<?php
namespace BusinessLogic\PostActions\TableCreation\TableCreationProducts;

class IndependentHouse
{
    public function isUsed(string $statementType): bool
    {
        return $statementType === "independent-house";
    }

    public function execute(array $statementFormData)
    {
        // create table, make record(s)
    }
}
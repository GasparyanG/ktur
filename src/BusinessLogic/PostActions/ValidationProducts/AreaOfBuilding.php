<?php
namespace BusinessLogic\PostActions\ValidationProducts;

class AreaOfBuilding
{
    public function isValid($fealdName)
    {
        // value taken from inputs/regular-inputs/area-of-building.html:ng-model
        return $fealdName === "buildingArea";
    }

    public function execute($fealdName, $fealdValue, $validator)
    {
               
    }
}
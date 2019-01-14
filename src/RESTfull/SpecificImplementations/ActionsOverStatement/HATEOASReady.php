<?php
namespace RESTfull\SpecificImplementations\ActionsOverStatement;

use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;

class HATEOASReady
{
    public function __construct()
    {
        $this->jsonPrep = new JsonPrepareness();
    }

    public function getPreparedArray($tableName, $uniqueIdentifier)
    {
        $star = "/statements/$tableName/$uniqueIdentifier/star";
        $comment = "/statements/$tableName/$uniqueIdentifier/comment";
        $basket = "/statements/$tableName/$uniqueIdentifier/basket";
        $delete = "/statements/$tableName/$uniqueIdentifier/deletion";
        $edit = "/statements/$tableName/$uniqueIdentifier/edit";

        $preparedArrayForJson = [];
        $preparedArrayForJson[] = $this->jsonPrep->makeHrefRestfull($star, "star");
        $preparedArrayForJson[] = $this->jsonPrep->makeHrefRestfull($comment, "comment");
        $preparedArrayForJson[] = $this->jsonPrep->makeHrefRestfull($basket, "basket");
        $preparedArrayForJson[] = $this->jsonPrep->makeHrefRestfull($delete, "deletion");
        $preparedArrayForJson[] = $this->jsonPrep->makeHrefRestfull($edit, "edit");

        return $preparedArrayForJson;
    }
}
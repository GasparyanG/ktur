<?php
namespace RESTfull\HATEOSA;

class JsonPrepareness
{
    public function makeHrefRestfull($pathToResource, $relationship)
    {
        $hrefAndRel = [
            "href"  => $pathToResource,
            "rel"   => $relationship,
        ];

        return $hrefAndRel;
    }
}
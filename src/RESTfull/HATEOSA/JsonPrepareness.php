<?php
namespace RESTfull\HATEOSA;

class JsonPrepareness
{
    public function makeHrefRestfull($pathToResource, $relationship, $data = null)
    {
        $hrefAndRel = [
            "href"  => $pathToResource,
            "rel"   => $relationship,
        ];

        if ($data){
            $hrefAndRel["data"] = $data;
        }

        return $hrefAndRel;
    }
}
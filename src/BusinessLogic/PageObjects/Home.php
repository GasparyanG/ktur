<?php
namespace BusinessLogic\PageObjects;

class Home
{
    public function getHome($req, $plHol)
    {
        echo "<pre>";
        var_dump($req);
        var_dump($plHol);
    }
}
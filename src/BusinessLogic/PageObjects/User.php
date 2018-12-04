<?php
namespace BusinessLogic\PageObjects;

class User
{
    public function getUser($req, $res, $routeInfo)
    {
        $cookies = $req->getCookieParams();
        $username = $cookies['user_name'];

        echo "<pre>";
        var_dump($routeInfo);
    }
}
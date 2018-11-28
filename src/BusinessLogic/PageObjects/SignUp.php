<?php
namespace BusinessLogic\PageObjects;

class SignUp
{
    public function getPage($req, $res, $routeInfo)
    {
        //$uri = $req::getUriFromGlobals();
        //$path = $uri->getPath();

        //echo $path;

        $res->render('sign-up.html', ['title' => 'Sign Up']);
    }
}
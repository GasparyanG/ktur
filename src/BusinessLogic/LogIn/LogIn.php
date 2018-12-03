<?php
namespace BusinessLogic\LogIn;

use Augmention\Convertion\JsonConverter as JsonConverter;
use Validation\SpecificValidators\Authentication\AuthenticationValidator as AuthenticationValidator;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class LogIn
{
    public function __construct()
    {
        // DRY principle need to be obayed!
        $this->dataForClient = [
            'title' => 'Log In',
        ];
    }

    public function getPage($req, $res, $routeInfo)
    {
        /**
         * Why user creadentials don't be sent to client side ?
         * 
         * - with angualr it is very easy to check data forwarded to front end,
         *   BUT security is a big problem for that reason sensetive data must be
         *   checked in server side!
         */
        $res->render('/templates/authentication/log-in-form.html', ['title' => $this->dataForClient['title']]);
    }

    public function accessToAccout($req, $res, $routeInfo)
    {
        /**
         * objects to rely on
         */
        $jsonConverter = new JsonConverter();
        $configFetcher = new ConfigFetcher();
        
        $parsedBodyFromAjaxCall = $req->getParsedBody();
        $parsedBody = $jsonConverter->parsedBodyKeyConvertToAssocArray($parsedBodyFromAjaxCall);
        
        $password = $parsedBody['password'];
        $username = $parsedBody['username'];
        $tableName = $configFetcher->fetchConf('DATABASE_CONFIG', ['DB1', 'tables', 'users']);
        
        $authValid = new AuthenticationValidator($password, $username, $tableName);

        $isAuthenticated = $authValid->authenticate();

        if (!$isAuthenticated) {
            echo 'false';
            exit;
        }

        echo "true";
    }
}
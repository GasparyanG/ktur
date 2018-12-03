<?php
namespace BusinessLogic\PageObjects;

use Validation\Validator as Validator;
use Validation\Sanitizer as Sanitizer;
use DataBase\Implementations\DBManipulator as DBManipulator;
use DataBase\Tables\Users as Users;
use Security\Password\Hasher as Hasher;
use Cookie\Cookie as Cookie;
use Augmention\Convertion\JsonConverter as JsonConverter;

class SignUp
{
    protected static $usernameExistsErrorMessaage = "Username already exists, please choose other!";

    public function getPage($req, $res, $routeInfo)
    {
        $this->renderSignUpPage($res, $parsedBody = null, $errorMessages = null);
    }

    public function createAccount($req, $res, $routeInfo)
    {
        /**
         * objects to relay on
         */
        $dbmanipulator = new DBManipulator();
        $validator = new Validator();
        $sanitizer = new Sanitizer();
        $hasher = new Hasher();
        $manipulatorOfCookie = new Cookie();
        $jsonConverter = new JsonConverter();

        $parsedBodyFromAjaxCall = $req->getParsedBody();

        $parsedBody = $jsonConverter->parsedBodyKeyConvertToAssocArray($parsedBodyFromAjaxCall);

        // if therer is no such value for given key then return empty string
        $username = $this->getKeyValuePair('username', $parsedBody);
        $password = $this->getKeyValuePair('password', $parsedBody);
        $firstName = $this->getKeyValuePair('first_name', $parsedBody);
        $lastName = $this->getKeyValuePair('last_name', $parsedBody);

        /**
         * validation of input fealds
         * 
         * @see Validation\Validator
         */
        $validator->isLength($username, ["min" => 1], "Username need to be at least 1 character");
        $validator->isLength($firstName, ["min" => 1], "First name need to be at least 1 character");
        $validator->isLength($lastName, ["min" => 1], "Last name need to be at least 1 character");
        $validator->isLength($password, ["min" => 1], "Password need to be at least 1 character");

        // return clollected error messages if any
        $errorMessages = $validator->getErrorMessages();

         /**
          * Sanitization of input fealds
          * 
          * @see Validation\Sanitizer
          */
          $username = $sanitizer->spaceTrim($username['username']);
          $firstName = $sanitizer->spaceTrim($firstName['first_name']);
          $lastName = $sanitizer->spaceTrim($lastName['last_name']);
          $password = $sanitizer->spaceTrim($password['password']);
        
        /**
         * Check whether usersname exists or not 
         * importance of this validation is very high, because almost whole app is relaying on username's uniquness!
         * 
         * DBManipulator can also be injected with getter!  
         */
        $usernameState = $this->isUnique($dbmanipulator, $username);

        /**
         * if (false)
         *  add error message to $errorMessages array
         * elseif(true)
         *  continue defind execution: create new row by injecting new credentials
         * elseif(null)
         *  continue defined execution: create new table, create new row by injecting new credentials
         */
        if ($usernameState === false and empty($errorMessages)) {
            $errorMessages["username"] = self::$usernameExistsErrorMessaage;
        }
    
        if (!empty($errorMessages)) {
            // XHR request will be done
            // $jsonParsedBody = json_encode($parsedBody);
            //echo $jsonParsedBody;
            $jsonErrorMessages = json_encode($errorMessages);
            echo $jsonErrorMessages;
            exit;
        }

        list($hashedPassword, $salt) = $hasher->hashPassword($password);
        $this->createAndInjectUserIntoTable($dbmanipulator, $firstName, $lastName, $username, $hashedPassword, $salt);

        $manipulatorOfCookie->setCookie("user_name", $username);
        $res->redirect("/$username");
    }

    private function renderSignUpPage($res, $parsedBody, $errorMessages)
    {
        $res->render('/templates/authentication/sign-up-form.html', ['title' => 'Sign Up', 'parsedBody' => $parsedBody, 'errorMessages' => $errorMessages]);
    }

    private function createAndInjectUserIntoTable($dbmanipulator, $firstName, $lastName, $username, $hashedPassword, $salt)
    {
        $usersTableCreationDefinition = $this->getUsersTableDef();
        $usersTableName = $usersTableCreationDefinition->getTableName();

        $statement = $usersTableCreationDefinition->getTableDef();

        /**
         * this flag (i.e. 'T') states about tabel creation
         * 
         * @see DataBase\Implementations\Creater
         */

        $dbmanipulator->create($statement, 'T');

        $userCreationDate = time();
        
        // YYYY-MM-DD
        // uppercase Y converts year to four digital format
        $sqlFormat = date('Y-m-d' ,$userCreationDate);

        $insertionStatement = "INSERT INTO $usersTableName(first_name, last_name, username, password, salt, sign_up_date)
        VALUES(\"$firstName\", \"$lastName\", \"$username\", \"$hashedPassword\", \"$salt\", \"$sqlFormat\")";

        // 'R' => Row
        // query result can be either null or last insert id
        $dbmanipulator->create($insertionStatement, "R");
    }

    private function isUnique($dbmanipulator, $username)
    {
        $usersTableCreationDefinition = $this->getUsersTableDef();
        $usersTableName = $usersTableCreationDefinition->getTableName();

        try
        {
            $statement = "SELECT username FROM $usersTableName WHERE username = \"$username\" LIMIT 1";
            $queryResult = $dbmanipulator->read($statement, "O");

            if (empty($queryResult)) {
                // unique!
                return true;
            }

            // not unique!
            return false;
        }
        catch(PDOException $exception)
        {
            // table don't exists!
            return null;
        }
    }

    private function getUsersTableDef()
    {
        return new Users();
    }

    private function getKeyValuePair(string $key, array $array): array
    {
        $desiredArray = [];

        $value = isset($array[$key]) ? $array[$key] : "";
        
        $desiredArray[$key] = $value;
        return $desiredArray;
    }
}
<?php
namespace BusinessLogic\PageObjects;

use Validation\Validator as Validator;
use Validation\Sanitizer as Sanitizer;
use DataBase\Implementations\DBManipulator as DBManipulator;
use DataBase\Tables\Users as Users;
use Security\Password\Hasher as Hasher;
use Cookie\Cookie as Cookie;

class SignUp
{
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

        $parsedBody = $req->getParsedBody();

        $username = $parsedBody['username'];
        $firstName = $parsedBody['first_name'];
        $lastName = $parsedBody['last_name'];
        $password = $parsedBody['password'];

        /**
         * validation of input fealds
         * 
         * @see Validation\Validator
         */
        $validator->isLength($firstName, ["min" => 1], "First name need to be at least 1 character");
        $validator->isLength($lastName, ["min" => 1], "Last name need to be at least 1 character");
        $validator->isLength($username, ["min" => 1], "Username need to be at least 1 character");
        $validator->isLength($password, ["min" => 1], "Password need to be at least 1 character");

        // return clollected error messages if any
        $errorMessages = $validator->getErrorMessages();

        /**
         * Sanitization of input fealds
         * 
         * @see Validation\Sanitizer
         */
        $username = $sanitizer->spaceTrim($username);
        $firstName = $sanitizer->spaceTrim($firstName);
        $lastName = $sanitizer->spaceTrim($lastName);
        $password = $sanitizer->spaceTrim($password);
    
        if (!empty($errorMessages)) {
            $this->renderSignupPage($res, $parsedBody, $errorMessages);
        }

        list($hashedPassword, $salt) = $hasher->hashPassword($password);
        $this->createAndInjectUserIntoTable($dbmanipulator, $firstName, $lastName, $username, $hashedPassword, $salt);

        $manipulatorOfCookie->setCookie("user_name", $username);
        $res->redirect("/$username");
    }

    private function renderSignUpPage($res, $parsedBody, $errorMessages)
    {
        $res->render('sign-up.html', ['title' => 'Sign Up', 'parsedBody' => $parsedBody, 'errorMessages' => $errorMessages]);
    }

    private function createAndInjectUserIntoTable($dbmanipulator, $firstName, $lastName, $username, $hashedPassword, $salt)
    {
        $usersTableCreationDefinition = new Users();
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
}
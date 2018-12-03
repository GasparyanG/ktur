<?php
namespace Validation\SpecificValidators\Authentication;

use DataBase\Implementations\DBManipulator as DBManipulator;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class AuthenticationValidator
{
    protected $passwordFromForm;
    protected $usernameFromForm;
    protected $tableName;

    /**
     * @param string $passwordFromForm
     * @param string $usernameFromForm
     * @param string $tableName
     */
    public function __construct($passwordFromForm, $usernameFromForm, $tableName)
    {
        /**
         * objects to rely on
         */
        $this->dbmanipulator = new DBManipulator();
        $this->configFetcher = new ConfigFetcher();

        $this->passwordFromForm = $passwordFromForm;
        $this->usernameFromForm = $usernameFromForm;
        $this->tableName = $tableName;

        $this->hashAlgorithm = $this->configFetcher->fetchConf('HASH_CONFIG', ['password', 'algorithm']);
    }

    /**
     * @return bool
     */
    public function authenticate()
    {
        // required variables for this method is object's properties!
        $selectCredentialsStatement = $this->getStatement();
        $credentialsFromDatabase = $this->fetchCredentialsFromDataBase($selectCredentialsStatement);

        if (!$credentialsFromDatabase) {
            return false;
        }

        $isValid = $this->checkPassword($credentialsFromDatabase);

        return $isValid;
    }

    /**
     * @param string $usernameFromForm
     * @param string $tableName
     */
    private function getStatement()
    {
        $selectCredentialsStatement = "SELECT password, salt FROM $this->tableName WHERE username = \"$this->usernameFromForm\"";

        return $selectCredentialsStatement;
    }

    private function fetchCredentialsFromDataBase($selectCredentialsStatement)
    {
        $credentialsFromDatabase = $this->dbmanipulator->read($selectCredentialsStatement, "O");

        // if db don't contain required data then false will be returned!
        return $credentialsFromDatabase;
    }

    private function checkPassword($credentialsFromDatabase)
    {
        // password being stored in database!
        $databaseHashedPassword = $credentialsFromDatabase['password'];
        $salt = $credentialsFromDatabase['salt'];

        // password passed from form is being hashed with salt!
        $hashedKeyAndPassword = $this->hashPasswordWithSalt($salt);

        if ($databaseHashedPassword !== $hashedKeyAndPassword) {
            return false;
        }

        return true;
    }

    private function hashPasswordWithSalt($salt)
    {
        $passwordAndSaltTogether = $this->passwordFromForm . $salt;
        $hashedKeyAndPassword = hash($this->hashAlgorithm, $passwordAndSaltTogether);

        return $hashedKeyAndPassword;
    }
}
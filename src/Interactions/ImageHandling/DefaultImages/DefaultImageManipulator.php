<?php
namespace Interactions\ImageHandling\DefaultImages;

use DataBase\Implementations\DBManipulator as DBManipulator;

class DefaultImageManipulator
{
    protected $defaultImageDirectories;
    protected $arrayOfFileNames;

    public function __construct()
    {
        $this->publicDir = __DIR__ . "/../../../../public/photos";
        $this->dbmanipulator = new DBManipulator();

        $this->defaultImageDirectories = [
            "user_images" => $this->publicDir . "/app-supporting-photos/user-default-photos",
        ];

        $this->arrayOfFileNames = $this->getArrayOfFileNames();
    }

    public function setUserDefaultImage($username)
    {
        $randomImagekey = array_rand($this->arrayOfFileNames);
        $randomImageName = $this->arrayOfFileNames[$randomImagekey];
        // create table
        $tableName = $this->dbmanipulator->createTable('user_components');

        $statementForDefaultImageInsertion = $this->getStatementForDefaultImageInsertion($username, $randomImageName, $tableName);

        $this->dbmanipulator->create($statementForDefaultImageInsertion, "R");
    }

    private function getArrayOfFileNames()
    {
        $userDefaultImageDirectory = $this->defaultImageDirectories['user_images'];
        $arrayOfDirectoryCapacity = scandir($userDefaultImageDirectory);


        // remove directory default "." and ".."
        if (count($arrayOfDirectoryCapacity) > 2 ) {
            array_shift($arrayOfDirectoryCapacity);   
            array_shift($arrayOfDirectoryCapacity);

            return $arrayOfDirectoryCapacity;
        }
    }

    private function getStatementForDefaultImageInsertion($username, $randomImageName, $tableName)
    {
        $statementForDefaultImageInsertion = "INSERT INTO $tableName(username, user_image)
        VALUES(\"$username\", \"$randomImageName\")";

        return $statementForDefaultImageInsertion;
    }
}
<?php
namespace BusinessLogic\FileSystemManipulation;

use Security\FileSystem\FileNames as FileNames;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use BusinessLogic\FileSystemManipulation\ManipulatorComponents\FileAdder as FileAdder;

class FileSystemManipulation
{
    public function __construct()
    {
        $this->fileAdder = new FileAdder();
        $this->fileNames = new FileNames();
        $this->configFetcher = new ConfigFetcher();
    }

    public function addStatementImage($req, $res, $routeInfo) 
    {
        $inputFieldName = $this->configFetcher->fetchConf("FORM_CONFIG", ["field_names", "statement_image_upload"]);
        $fileName = $this->fileNames->makeStatementImageName($req, $inputFieldName);
        /////////////
        //validation need to be implemented here
        ////////////

        //tmp_name need to be fetched from $_CLIENT then passed to addImageToSpecificDirectory
        $tmpName = $_FILES[$inputFieldName]['tmp_name']; // $req->getUploadedFiles()[$inputFieldName]->getStream();
        $this->fileAdder->addImageToSpecificDirectory($tmpName, $fileName, "statement");
    }
}
<?php
namespace BusinessLogic\FileSystemManipulation;

use Security\FileSystem\FileNames as FileNames;
use Interactions\Config\ConfigFetcher as ConfigFetcher;

class FileSystemManipulation
{
    public function __construct()
    {
        $this->fileNames = new FileNames();
        $this->configFetcher = new ConfigFetcher();
    }

    public function addStatementImage($req, $res, $routeInfo) 
    {
        $inputFieldName = $this->configFetcher->fetchConf("FORM_CONFIG", ["field_names", "statement_image_upload"]);

        $fileName = $this->fileNames->makeStatementImageName($req, $inputFieldName);
        // var_dump($req->getServerParams());
        // copy($_FILES['fileInput']['tmp_name'], __DIR__ . 
        // "/../../../public/photos/business-logic-photos/statement-photos/" . $_FILES['fileInput']['name']);
    }
}
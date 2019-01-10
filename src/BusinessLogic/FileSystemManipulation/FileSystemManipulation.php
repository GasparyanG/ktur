<?php
namespace BusinessLogic\FileSystemManipulation;

use Security\FileSystem\FileNames as FileNames;
use Interactions\Config\ConfigFetcher as ConfigFetcher;
use BusinessLogic\FileSystemManipulation\ManipulatorComponents\FileAdder as FileAdder;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use Augmention\Convertion\JsonConverter as JsonConverter;
use BusinessLogic\FileSystemManipulation\ManipulatorComponents\FileRemover as FileRemover;

class FileSystemManipulation
{
    public function __construct()
    {
        $this->jsonConverter = new JsonConverter();
        $this->jsonPrepareness = new JsonPrepareness();
        $this->fileAdder = new FileAdder();
        $this->fileNames = new FileNames();
        $this->configFetcher = new ConfigFetcher();
        $this->fileRemover = new FileRemover();
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

        $servingPath = $this->configFetcher->fetchConf("URI_CONFIG", ["photos", "statement_photos", "directory"]) . $fileName;
        $restPrepared = $this->jsonPrepareness->makeHrefRestfull($servingPath, "uploadedImage", $fileName);
        
        // client can handle this kind of data structure; checkout js/user/factory/factory.js
        $restPrepared = [$restPrepared];
        $convertedToJson = $this->jsonConverter->convertArrayToJson($restPrepared);

        echo $convertedToJson;
    }
}
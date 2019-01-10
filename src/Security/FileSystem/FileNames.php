<?php
namespace Security\FileSystem;

use Psr\Http\Message\ServerRequestInterface as ServerRequestInterface;
use Validation\SpecificValidators\FileUploadValidation\FileUploadValidator as FileUploadValidator;

class FileNames
{
    public function __construct()
    {
        $this->fileUploadValidator = new FileUploadValidator();
    }
    
    public function makeStatementImageName(ServerRequestInterface $req, string $inputFieldName)
    {
        // extension based on MIME tpye
        $extension = $this->getExtension($req, $inputFieldName);
        //user ip
        $userIP = $this->getUserIp($req);
        // portions of file name
        $timeSegment = $this->integrateTime();
        // composition
        $composedPortions = $userIP . "-" . $timeSegment . $extension;

        return $composedPortions;
    }

    public function integrateTime()
    {
        return time();
    }

    /**
     * users can add images at the same second and create the same filename
     * IP will ensure that that kind of problem will not happen
     */
    private function getUserIp(ServerRequestInterface $req)
    {
        $serverParams = $req->getServerParams();
        $IP = $serverParams['REMOTE_ADDR'];

        if ($IP === "::1") {
            return "admin-added-photo";
        }

        return $IP;
    }

    private function getExtension(ServerRequestInterface $req, string $inputFieldName)
    {
        $uploadedFiles = $req->getUploadedFiles();
        // UploadFile object
        $fileMimeType = $uploadedFiles[$inputFieldName]->getClientMediaType();

        $extension = $this->fileUploadValidator->validateMimeType($fileMimeType);

        if (!$extension) {
            // prompt user about iamge types, which are supported
        }

        return $extension;
    }
}
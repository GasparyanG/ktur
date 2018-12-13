<?php
namespace Security\FileSystem;

use Psr\Http\Message\ServerRequestInterface as ServerRequestInterface;

class FileNames
{
    
    public function makeStatementImageName(ServerRequestInterface $req, string $inputFieldName)
    {
        $extension = $this->getExtension($req, $inputFieldName);

        $userIP = $this->getUserIp($req);
        // portions of file name
        $timeSegment = $this->integrateTime();

        $composedPortions = $userIP . "-" . $timeSegment
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
        $serverParams = $req->getServerParams();
        $fileMimeType = $serverParams[$inputFieldName]['type'];

        // $this->validator validate mime type
    }
}
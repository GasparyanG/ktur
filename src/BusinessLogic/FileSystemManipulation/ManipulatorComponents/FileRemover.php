<?php
namespace BusinessLogic\FileSystemManipulation\ManipulatorComponents;

class FileRemover
{
    public function __construct()
    {
        $this->businessLogicPhotosDirectory = __DIR__ . "/../../../../public/photos/business-logic-photos";

        $this->specificDirs = [
            'statement-photos' => $this->businessLogicPhotosDirectory . "/statement-photos",
        ];
    }

    public function removeFile(array $fileState, string $specificDirName)
    {
        /*
        {
        "deleteAll" : true,
        "deleteFrom" : [],
        "saveTo" : []
        }; 
        */

        $deleteAll = $fileState["deleteAll"];
        $deleteFrom = $fileState["deleteFrom"];
        $saveTo = $fileState["saveTo"];

        if ($deleteAll) {
            if ($deleteFrom !== 0) {
                $this->deleteFiles($deleteFrom, $specificDirName);
            }

            if ($saveTo !==0) {
                $this->deleteFiles($saveTo, $specificDirName);
            }
        }

        else {
            if ($deleteFrom !== 0) {
                $this->deleteFiles($deleteFrom, $specificDirName);
            }
        }
    }

    private function deleteFiles(array $filesToDelete, string $specificDirName)
    {
        $specificDir = $this->specificDirs[$specificDirName];
        foreach($filesToDelete as $fileName) {
            $filefullPath = $specificDir . $fileName;
            unlink($filefullPath);
        }
    }
}
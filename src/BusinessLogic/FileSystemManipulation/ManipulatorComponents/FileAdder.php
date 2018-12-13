<?php
namespace BusinessLogic\FileSystemManipulation\ManipulatorComponents;

class FileAdder
{
    public function __construct()
    {
        $this->businessLogicPhotosDirectory = __DIR__ . "/../../../../public/photos/business-logic-photos";
        // directory need to have trailing slash to be careless about file 'root' slash!
        $this->imageDirectories = [
            "statement" => $this->businessLogicPhotosDirectory . "/statement-photos/",
        ];
    }

    public function addImageToSpecificDirectory(string $tmpName, string $fileName, string $dirKeyWord)
    {
        $directory = $this->getDirectory($dirKeyWord);
        $fullPath = $directory . $fileName;

        return copy($tmpName, $fullPath);
    }

    private function getDirectory(string $dirKeyWord)
    {
        $lowerKeyword = strtolower($dirKeyWord);

        if (!isset($this->imageDirectories[$lowerKeyword])) {
            throw new \InvalidArgumentException("$lowerKeyword is not defied in iamgeDerectories array");
        }

        $directory = $this->imageDirectories[$lowerKeyword];
        $validatedDirectory = $this->validateTrailingSlash($directory);

        return $directory;
    }

    // directory need to have trailing slash to be careless about file 'root' slash!
    private function validateTrailingSlash(string $directory): string
    {
        if (substr($directory, -1) === "/") {
            return $directory;
        }

        return $directory . "/";
    }
}
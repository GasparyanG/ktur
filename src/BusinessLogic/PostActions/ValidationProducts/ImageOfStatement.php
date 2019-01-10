<?php
namespace BusinessLogic\PostActions\ValidationProducts;

use BusinessLogic\FileSystemManipulation\ManipulatorComponents\FileRemover as FileRemover;

class ImageOfStatement
{
    public function __construct()
    {
        $this->fileRemover = new FileRemover();
    }

    public function isValid($fieldName)
    {
        return $fieldName === "image-upload";
    }

    public function execute($fieldName, $fieldValue, $validator)
    {
        $validator->vaildateFileState($fieldName, $fieldValue);
        // remove unnecessary files with $this->fileRemover!
    }
}
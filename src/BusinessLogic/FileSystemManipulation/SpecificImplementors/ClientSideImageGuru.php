<?php
namespace BusinessLogic\FileSystemManipulation\SpecificImplementors;

class ClientSideImageGuru
{
    public function getSaveToArray(array $statementFormData)
    {
        $imageArray = $statementFormData["image-upload"];

        return $imageArray["saveTo"];
    }
}
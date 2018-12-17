<?php
namespace Validation\SpecificValidators\FileUploadValidation;

class FileUploadValidator
{

    public function __construct()
    {
        $this->fileState = [
            "saveTo" => "saveTo"
        ];

        $this->appAcceptedMimeTypes = [
            // JPEG Image
            ".jpeg" => "image/jpeg",
            // PNG Image
            ".png" => "image/png",
        ];
    }

    public function validateMimeType(string $mimeType)
    {
        foreach($this->appAcceptedMimeTypes as $extension => $appMimeType) {
            if (preg_match("~$appMimeType~i", $mimeType)) {
                return $extension;
            }
        }

        // mime type does not found
        return false;
    }

    public function haveItemToSave(array $fileState)
    {
        return $fileState[$this->fileState['saveTo']] === 0 ? false : true;
    }
}

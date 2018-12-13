<?php
namespace Validation\SpecificValidators\FileUploadValidation;

class FileUploadValidator
{

    public function __construct()
    {
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
}

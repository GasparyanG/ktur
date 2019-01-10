<?php
namespace Augmention\Convertion;

class JsonConverter
{
    /**
     * @param array $arr array will be converted to string which will have json format
     */
    public function convertArrayToJson(array $arr)
    {
        $arrayConvertedToJson = json_encode($arr);

        return $arrayConvertedToJson;
    }

    /**
     * form body will be stored in key of assoc array forwarded from clent with ajax call:
     * array in its turn will store json format data
     * 
     * To interact with json stored data it will be decoded (converted) to assoc array
     * with help of php built in json_decode fucntion, which takes following agruments:
     * 
     * 1) required argument is of json format
     * 2) optional but required in this api is boolean, based on which json will be converted to assoc array!
     * 
     * @param mixed[] $parsedBodyFromAjaxCall
     */

    public function parsedBodyKeyConvertToAssocArray($parsedBodyFromAjaxCall)
    {
     
        foreach($parsedBodyFromAjaxCall as $key => $value) {
            // blah blah blah            
        }
        $parsedBody = json_decode($key);

        return $parsedBody;
    }

    public function jsonDecodeWithFileGetContents()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }
}
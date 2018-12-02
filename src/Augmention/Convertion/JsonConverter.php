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
}
<?php

namespace Saikat\camelCase;

class camelCase 
{


    public static function camelCase($array)
    {        

        if (is_array($array)) {            
            return self::arrayConverter($array);
        } 
        else {
            $json = json_decode($array, true);
            if (json_last_error() == JSON_ERROR_NONE) {
                return self::jsonConverter($json);
            } else {
                echo "Invalid Json or Array";
            }
        }
    }

    private static function arrayConverter($array)
    {
        $renameArray = array();
        $rules = ['_', ' ', '-', '"', "'"];

        //loop each row of array
        foreach ($array as $key => $value) {

            $new = lcfirst(str_replace($rules, '', ucwords($key, ' _-')));
            $renameArray[$new] = $array[$key]; // cast value to string data type
            unset($array[$key]);
            //if the value is array, it will do the recursive
            if (is_array($value)) {
                $renameArray[$new] = self::arrayConverter($value);
            }
        }
        return $renameArray;
    }

    private static function jsonConverter($json)
    {
        $jsonArray = array();

        //loop each row of array
        foreach ($json as $key => $value) {

            $rules = ['_', ' ', '-', '"', "'"];
            $new = lcfirst(str_replace($rules, '', ucwords($key, ' _-')));
            $jsonArray[$new] = $json[$key]; // cast value to string data type
            unset($json[$key]);

            //if the value is array, it will do the recursive
            if (is_array($value)) {
                $jsonArray[$new] = self::jsonConverter($value);
            }
        }

        return json_encode($jsonArray);
    }
}

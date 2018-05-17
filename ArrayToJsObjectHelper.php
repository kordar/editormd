<?php
namespace kordar\editormd;

class ArrayToJsObjectHelper
{
    public static function conversionToJsObject($array = [])
    {
        $js = [];
        foreach ($array as $key => $item) {
            switch (true) {
                case is_numeric($item):
                    $js[] = $key . ':' . $item;
                    break;

                case is_string($item):
                    $js[] = $key . ':' . (empty($item)?'""':"\"{$item}\"");
                    break;

                case is_bool($item):
                    $js[] = $key . ':' . ($item?'true':'false');
                    break;

                case is_array($item):
                    $js[] = $key . ':' . '["' . implode('","', $item) . '"]';
                    break;
            }
        }
        return '{' . implode(',', $js) . '}';
    }
}
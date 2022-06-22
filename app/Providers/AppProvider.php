<?php

namespace App\Providers;

class AppProvider{

    /**
     * register global variable
     * 
     */
    public static function register(){
        $content = (file_get_contents("../.env"));
        $arr = explode("\n", $content);
        $envArr = [];
        foreach ($arr as $item) {
            $split = explode("=", $item);
            $value = trim($split[1]);
           
            switch ($value) {
                case 'true':
                    $value = true;
                    break;
                case 'false':
                    $value = false;
                    break;
            }

            $envArr[$split[0]] = $value;
        }

        $GLOBALS['envArr']=$envArr;
    }
}
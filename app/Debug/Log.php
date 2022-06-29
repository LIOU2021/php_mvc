<?php

namespace App\Debug;

class Log
{
    const DEFAULTPATH = __DIR__."/../../storage/logs";

    /**
     * write debug to project/storage/logs
     */
    public static function debug($file,$line,$data = null)
    {
        $response = date('Y-m-d H:i:s')." : ".$file."@".$line." : ".json_encode($data, JSON_PRETTY_PRINT)."\n\n";

        file_put_contents(self::DEFAULTPATH . '/debug.log',$response , FILE_APPEND);

        return $response;
    }
}

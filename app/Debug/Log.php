<?php

namespace App\Debug;

class Log
{
    const DEFAULTPATH = __DIR__."\..\..\storage\logs";

    /**
     * write debug to project/storage/logs
     */
    public static function debug($file,$line,$data = null)
    {
        // return self::DEFAULTPATH . '\debug.log';
        file_put_contents(self::DEFAULTPATH . '\debug.log', $file."@".$line." : ".json_encode($data, JSON_PRETTY_PRINT)."\n\n", FILE_APPEND);
    }
}

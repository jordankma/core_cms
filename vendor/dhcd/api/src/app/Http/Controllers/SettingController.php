<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Validator;
use Cache;
use Crypt;

class SettingController extends BaseController
{
    public function version()
    {
        $data = '{
                    "data" :{
                        "version": 2
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function appDebug()
    {
        $filePath = base_path('apk/app-debug.apk');

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filePath");
        header("Content-Type: application/octet-stream");
        header('Content-Length: ' . filesize($filePath));
        header("Content-Transfer-Encoding: binary");

        // read the file from disk
        readfile($filePath);
    }
}
<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Validator;
use Cache;

trait Domain
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getDomain(){
        $domain = "dhcd.vnedutech.vn";
        $data = '{
                    "data": {
                        "domain": '. json_encode($domain) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getDisplay(){
        $image = "dhcd.vnedutech.vn";
        $slogan = "image.img";
        $data = '{
                    "data": {
                        "image": '. json_encode($image) .',
                        "slogan": '. json_encode($slogan) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');    
    }

}
<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Notification\App\Models\LogSent as LogSentModel;
use Illuminate\Support\Facades\DB;
use Validator;
use Cache;

trait LogSent
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getLogSent(){
        $log_sents = LogSentModel::orderBy('log_sent_id', 'desc')->with('notification')->paginate(20);
        $list_log_sent = array();
        $total_page = '';
        $page = '';
        if (count($log_sents) > 0) {
            $log_sents_arr = $log_sents->toArray();
            $total_page = $log_sents_arr['total'];
            $page = $log_sents_arr['current_page'];
            foreach ($log_sents as $key => $value) {
                $list_log_sent[] = [
                    'log_sent_id' => $value->log_sent_id,
                    'name' => base64_encode($value->notification->name),
                    'content' => base64_encode($value->notification->content),
                    'created_at' => $value->created_at
                ];     
            }    
        }
        $data = '{
                    "data": {
                        "list_log_sent": '. json_encode($list_log_sent) .',
                        "total_page": ' . $total_page . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getLogSentDetail($request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $id = $request->input('id');
            $log_sent = LogSentModel::where('log_sent_id',$id)->with('notification')->first();
            $log_sent_data = [
                    'log_sent_id' => $log_sent->log_sent_id,
                    'name' => base64_encode($log_sent->notification->name),
                    'content' => base64_encode($log_sent->notification->content),
                    'created_at' => $log_sent->created_at
                ];
            $data = '{
                    "data": '. json_encode($log_sent_data) .',
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);
            return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        } else {
            return $validator->messages();
        }
    }
}
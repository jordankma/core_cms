<?php

namespace Dhcd\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Dhcd\News\App\Http\Requests\ApiNewsRequest;

use Dhcd\News\App\Models\News;

use Validator;


class ApiNewsController extends BaseController
{	
	private $messages = array(
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
	public function getNews(ApiNewsRequest $request){
		$data_message = ['success' => false, 'message' => 'Lỗi khi lấy tin tức home'];
		if(isset($request->limit) && $request->limit !=''){
			$limit = $request->limit;
		}
		else{
			$limit = 8;	
		}
		$data_list_news = array();
		$list_news = News::where('status',1)->paginate($limit)->toArray();
		if(!empty($list_news)){
			$total_page = $list_news['total'];
			$current_page = $list_news['current_page'];
			foreach ($list_news['data'] as $key => $news) {
				$data_list_news[] =[
					"id" => $news['news_id'],
                    "title" => base64_encode($news['title']),
                    "sub_title" => base64_encode(json_decode($news['news_cat'],true)[0]['name'].' - '.$news['created_at']),
                    "describe" => base64_encode($news['desc']),
                    "photo" => $news['image'],
                    "content" => base64_encode($news['content']),
                    "date_created" => $news['created_at'],
                    "date_modified" => $news['updated_at'],
                    "is_top_new" => $news['is_hot'] == 1 ? true : false
				];	
			}
			$data = [
				'data'=>[
					'list_news'=>$data_list_news,
					"total_page"=>$total_page,
	            	"current_page"=>$current_page,
				],
	            "success"=> true,
	            "message"=> "Lấy danh sách tin tức home thành công"
			];
			// return json_encode($data);
			return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}	
		else{
			return response(json_encode($data_message))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}
	}   
	public function getNewsHome(ApiNewsRequest $request){
		$data_message = ['success' => false, 'message' => 'Lỗi khi lấy tin tức'];
		if(isset($request->limit) && $request->limit !=''){
			$limit = $request->limit;
		}
		else{
			$limit = 8;	
		}
		$data_list_news = array();
		$list_news = News::where('status',1)->orderBy('is_hot', 'asc')->paginate($limit)->toArray();
		if(!empty($list_news)){
			$total_page = $list_news['total'];
			$current_page = $list_news['current_page'];
			foreach ($list_news['data'] as $key => $news) {
				$data_list_news[] =[
					"id" => $news['news_id'],
                    "title" => base64_encode($news['title']),
                    "sub_title" => base64_encode(json_decode($news['news_cat'],true)[0]['name'].' - '.$news['created_at']),
                    "describe" => base64_encode($news['desc']),
                    "photo" => $news['image'],
                    "content" => base64_encode($news['content']),
                    "date_created" => $news['created_at'],
                    "date_modified" => $news['updated_at'],
                    "is_top_new" => $news['is_hot']==1 ? true	:false
				];	
			}
			$data = [
				'data'=>[
					'list_news_home'=>$data_list_news,
					"total_page"=>$total_page,
	            	"current_page"=>$current_page,
				],
	            "success"=> true,
	            "message"=> "Lấy danh sách tin tức home thành công"
			];
			return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}	
		else{
			return response(json_encode($data_message))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}
	} 
	public function getNewsDetail(ApiNewsRequest $request){
		$validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ], $this->messages);
        if (!$validator->fails()) {
			$data_message = ['success' => false, 'message' => 'Lỗi khi lấy chi tiết tin tức'];
			$news_id = $request->id;
			$news = News::find($news_id);
			if(!empty($news)){
				$news = $news->toArray();
				$data_news = [
					"id"=> $news['news_id'],
	                "title"=> base64_encode($news['title']),
	                "display_name"=> base64_encode($news['title']),
	                "photo"=> $news['image'],
	                "content" => base64_encode($news['content']), 
	                "content_html"=> base64_encode($news['content']),        
	                "date_created"=> $news['created_at'],
	                "date_modified"=> $news['updated_at']
				];
				$data = [
					'data'=>$data_news,
					"success" => true,
	                "message" => "Lấy chi tiết tin tức thành công"
				];
				return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
			}
			else{
				return response(json_encode($data_message))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
			}
		}
		else{
			return $validator->messages();   
		}
	}
}
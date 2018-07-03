<?php

namespace Dhcd\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\News\App\Http\Requests\ApiNewsRequest;

use Dhcd\News\App\Models\News;

use Validator;
class ApiNewsController extends Controller
{	
	private $messages = array(
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
	public function getNews(ApiNewsRequest $request){
		$data_message = ['success' => false, 'message' => 'Lỗi khi lấy tin tức home'];
		$limit = $request->limit;
		$data_list_news = array();
		$list_news = News::where('visible',1)->paginate($limit)->toArray();
		$total_page = $list_news['total'];
		$current_page = $list_news['current_page'];
		if(!empty($list_news)){
			foreach ($list_news['data'] as $key => $news) {
				$data_list_news[] =[
					"id" => $news['news_id'],
                    "title" => base64_encode($news['title']),
                    "sub_title" => base64_encode($news['desc']),
                    "photo" => base64_encode($news['image']),
                    "content" => base64_encode($news['content']),
                    "date_created" => $news['created_at'],
                    "date_modified" => $news['updated_at'],
                    "is_top_new" => $news['is_hot']==1 ? true	:false
				];	
			}
			$data = [
				'data'=>$data_list_news,
				"total_page"=>$total_page,
	            "current_page"=>$current_page,
	            "success"=> true,
	            "message"=> "Lấy danh sách tin tức home thành công"
			];
			// return json_encode($data);
			return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}	
		else{
			return json_encode($data_message);
		}
	}   
	public function getNewsHome(ApiNewsRequest $request){
		$data_message = ['success' => false, 'message' => 'Lỗi khi lấy tin tức'];
		$limit = $request->limit;
		$data_list_news = array();
		$list_news = News::where('visible',1)->orderBy('is_hot', 'asc')->paginate($limit)->toArray();
		$total_page = $list_news['total'];
		$current_page = $list_news['current_page'];
		if(!empty($list_news)){
			foreach ($list_news['data'] as $key => $news) {
				$data_list_news[] =[
					"id" => base64_encode($news['news_id']),
                    "title" => base64_encode($news['title']),
                    "sub_title" => base64_encode($news['desc']),
                    "photo" => base64_encode($news['image']),
                    "content" => base64_encode($news['content']),
                    "date_created" => $news['created_at'],
                    "date_modified" => $news['updated_at'],
                    "is_top_new" => $news['is_hot']==1 ? true	:false
				];	
			}
			$data = [
				'data'=>$data_list_news,
				"total_page"=>$total_page,
	            "current_page"=>$current_page,
	            "success"=> true,
	            "message"=> "Lấy danh sách tin tức thành công"
			];
			return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}	
		else{
			return json_encode($data_message);
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
					"id"=> base64_encode($news['news_id']),
	                "title"=> base64_encode($news['title']),
	                "display_name"=> base64_encode($news['title']),
	                "photo"=> base64_encode($news['image']),
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
				return json_encode($data_message);
			}
		}
		else{
			return $validator->messages();   
		}
	}
}
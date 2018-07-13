<?php

namespace Dhcd\Art\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Art\App\Repositories\DemoRepository;
use Dhcd\Art\App\Models\Demo;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ArtController extends Controller
{
	public function index(){
		return view('DHCD-ART::modules.art.index.home');
	}

	public function newsList(){
		return view('DHCD-ART::modules.art.news.list');	
	}

	public function newsDetail(){
		return view('DHCD-ART::modules.art.news.detail');
	}

	public function eventsList(){
		return view('DHCD-ART::modules.art.events.list');	
	}

	public function memberProfile(){
		return view('DHCD-ART::modules.art.profile.detail');	
	}
}
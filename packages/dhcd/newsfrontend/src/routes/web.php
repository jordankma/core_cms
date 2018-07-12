<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {

    Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('news/list', 'NewsFrontendController@list')->name('news.frontend.list')->where('as','Tin tức');
	    Route::get('news/detail', 'NewsFrontendController@detail')->name('news.frontend.detail');
	});
});
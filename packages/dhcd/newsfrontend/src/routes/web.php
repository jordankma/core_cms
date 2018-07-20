<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {

    Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('news/list', 'NewsfrontendController@list')->name('news.frontend.list')
	    ->where('as','Tin tức');

	    Route::get('news/category', 'NewsfrontendController@listCate')->name('news.frontend.list.cate')
	    ->where('type','tintuc')
	    ->where('view','list')
	    ->where('as','Tin tức - Theo danh mục');

	    Route::get('news/detail', 'NewsfrontendController@detail')->name('news.frontend.detail')
	    ->where('type','tintuc')
	    ->where('view','detail')
	    ->where('as','Tin tức- Chi tiết');
	});
});
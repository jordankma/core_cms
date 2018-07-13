<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
	Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('/', 'IndexController@index')->name('frontend.homepage')->where('as','Trang chủ');
	});
});

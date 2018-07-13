<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');;:
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('topic/list', 'TopicfrontendController@list')->name('topic.frontend.list')->where('as','Thảo luận');
	    Route::get('topic/detail', 'TopicfrontendController@detail')->name('topic.frontend.detail');
	});
});
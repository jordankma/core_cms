<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {

    Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('events/list', 'EventsFrontendController@list')->name('events.frontend.list')->where('as','Chương trình');
	});
});
<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('profile', 'ProfileController@profile')->name('profile.frontend.member')->where('as','Thông tin cá nhân');
	    Route::get('xedit', 'ProfileController@xedit')->name('xedit.frontend.member');

	    Route::post('change-pass', 'ProfileController@changePass')->name('changepass.frontend.member');

	    Route::group(array('prefix' => 'xedit'), function() {
	    	Route::post('change-name', 'ProfileController@changeName')->name('changename.frontend.member');			
	    });
	});
});
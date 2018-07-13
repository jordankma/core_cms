<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('profile', 'ProfileController@profile')->name('profile.frontend.member')->where('as','Thông tin cá nhân');

	    Route::post('change-pass', 'ProfileController@changePass')->name('changepass.frontend.member');
	});
});
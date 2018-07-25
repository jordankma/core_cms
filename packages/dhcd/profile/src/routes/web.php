<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['dhcd.auth']], function () {
	    Route::get('profile', 'ProfileController@profile')->name('profile.frontend.member')->where('as','Thông tin cá nhân');
	    Route::get('xedit', 'ProfileController@xedit')->name('xedit.frontend.member');

	    Route::post('change-pass', 'ProfileController@changePass')->name('changepass.frontend.member');
	    Route::post('change-avatar', 'ProfileController@changeAvatar')->name('changeavatar.frontend.member');
	    Route::group(array('prefix' => 'xedit'), function() {
	    	Route::post('change-name', 'ProfileController@changeName')->name('change.name.frontend.member');			
	    	Route::post('change-dan-toc', 'ProfileController@changeDanToc')->name('change.dantoc.frontend.member');			
	    	Route::post('change-address', 'ProfileController@changeAddress')->name('change.address.frontend.member');			
	    	Route::post('change-ton-giao', 'ProfileController@changeTonGiao')->name('change.tongiao.frontend.member');			
	    });
	});
});
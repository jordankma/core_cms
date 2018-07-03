<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/banner/banner/log', 'BannerController@log')->name('dhcd.banner.banner.log');
        Route::get('dhcd/banner/banner/data', 'BannerController@data')->name('dhcd.banner.banner.data');
        Route::get('dhcd/banner/banner/manage', 'BannerController@manage')->name('dhcd.banner.banner.manage');
        Route::get('dhcd/banner/banner/create', 'BannerController@create')->name('dhcd.banner.banner.create');
        Route::post('dhcd/banner/banner/add', 'BannerController@add')->name('dhcd.banner.banner.add');
        Route::get('dhcd/banner/banner/show', 'BannerController@show')->name('dhcd.banner.banner.show');
        Route::post('dhcd/banner/banner/update', 'BannerController@update')->name('dhcd.banner.banner.update');
        Route::get('dhcd/banner/banner/delete', 'BannerController@delete')->name('dhcd.banner.banner.delete');
        Route::get('dhcd/banner/banner/confirm-delete', 'BannerController@getModalDelete')->name('dhcd.banner.banner.confirm-delete');
    });
});
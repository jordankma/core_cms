<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/art/demo/log', 'DemoController@log')->name('dhcd.art.demo.log');
        Route::get('dhcd/art/demo/data', 'DemoController@data')->name('dhcd.art.demo.data');
        Route::get('dhcd/art/demo/manage', 'DemoController@manage')->name('dhcd.art.demo.manage');
        Route::get('dhcd/art/demo/create', 'DemoController@create')->name('dhcd.art.demo.create');
        Route::post('dhcd/art/demo/add', 'DemoController@add')->name('dhcd.art.demo.add');
        Route::get('dhcd/art/demo/show', 'DemoController@show')->name('dhcd.art.demo.show');
        Route::put('dhcd/art/demo/update', 'DemoController@update')->name('dhcd.art.demo.update');
        Route::get('dhcd/art/demo/delete', 'DemoController@delete')->name('dhcd.art.demo.delete');
        Route::get('dhcd/art/demo/confirm-delete', 'DemoController@getModalDelete')->name('dhcd.art.demo.confirm-delete');

        Route::get('dhcd/art/index', 'ArtController@index');

        Route::get('dhcd/art/news/list', 'ArtController@newsList');
        Route::get('dhcd/art/news/detail', 'ArtController@newsDetail');

        Route::get('dhcd/art/events/list', 'ArtController@eventsList');

        Route::get('dhcd/art/notifications/list', 'ArtController@notificationsList');
        Route::get('dhcd/art/notifications/detail', 'ArtController@notificationsDetail');
        
        Route::get('dhcd/art/document/van-kien', 'ArtController@vanKienList');
        Route::get('dhcd/art/document/van-kien', 'ArtController@vanKienDetail');


    });
});
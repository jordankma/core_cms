<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/notification/demo/log', 'DemoController@log')->name('dhcd.notification.demo.log');
        Route::get('dhcd/notification/demo/data', 'DemoController@data')->name('dhcd.notification.demo.data');
        Route::get('dhcd/notification/demo/manage', 'DemoController@manage')->name('dhcd.notification.demo.manage');
        Route::get('dhcd/notification/demo/create', 'DemoController@create')->name('dhcd.notification.demo.create');
        Route::post('dhcd/notification/demo/add', 'DemoController@add')->name('dhcd.notification.demo.add');
        Route::get('dhcd/notification/demo/show', 'DemoController@show')->name('dhcd.notification.demo.show');
        Route::put('dhcd/notification/demo/update', 'DemoController@update')->name('dhcd.notification.demo.update');
        Route::get('dhcd/notification/demo/delete', 'DemoController@delete')->name('dhcd.notification.demo.delete');
        Route::get('dhcd/notification/demo/confirm-delete', 'DemoController@getModalDelete')->name('dhcd.notification.demo.confirm-delete');
    });
});
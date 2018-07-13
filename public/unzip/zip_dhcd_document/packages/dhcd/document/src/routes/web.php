<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/document/demo/log', 'DemoController@log')->name('dhcd.document.demo.log');
        Route::get('dhcd/document/demo/data', 'DemoController@data')->name('dhcd.document.demo.data');
        Route::get('dhcd/document/demo/manage', 'DemoController@manage')->name('dhcd.document.demo.manage');
        Route::get('dhcd/document/demo/create', 'DemoController@create')->name('dhcd.document.demo.create');
        Route::post('dhcd/document/demo/add', 'DemoController@add')->name('dhcd.document.demo.add');
        Route::get('dhcd/document/demo/show', 'DemoController@show')->name('dhcd.document.demo.show');
        Route::put('dhcd/document/demo/update', 'DemoController@update')->name('dhcd.document.demo.update');
        Route::get('dhcd/document/demo/delete', 'DemoController@delete')->name('dhcd.document.demo.delete');
        Route::get('dhcd/document/demo/confirm-delete', 'DemoController@getModalDelete')->name('dhcd.document.demo.confirm-delete');
        
        Route::group(['prefix' => 'dhcd/document/cate'], function () {
            Route::get('manage', 'DocumentCateController@manage')->name('dhcd.document.cate.manage');
            Route::get('add', 'DocumentCateController@add')->name('dhcd.document.cate.add');
            Route::post('create', 'DocumentCateController@create')->name('dhcd.document.cate.create');
            Route::get('data', 'DocumentCateController@data')->name('dhcd.document.cate.data');
            Route::get('edit', 'DocumentCateController@edit')->name('dhcd.document.cate.edit');
            Route::post('update}', 'DocumentCateController@update')->name('dhcd.document.cate.update');
            Route::get('delete', 'DocumentCateController@delete')->name('dhcd.document.cate.delete');
        });
        
        Route::group(['prefix' => 'dhcd/document/type'], function () {
            Route::get('manage', 'DocumentTypeController@manage')->name('dhcd.document.type.manage');
            Route::get('add', 'DocumentTypeController@add')->name('dhcd.document.type.add');
            Route::post('create', 'DocumentTypeController@create')->name('dhcd.document.type.create');
            Route::get('data', 'DocumentTypeController@data')->name('dhcd.document.type.data');
            Route::get('edit', 'DocumentTypeController@edit')->name('dhcd.document.type.edit');
            Route::post('update}', 'DocumentTypeController@update')->name('dhcd.document.type.update');
            Route::get('delete', 'DocumentTypeController@delete')->name('dhcd.document.type.delete');
        });
        
    });
});
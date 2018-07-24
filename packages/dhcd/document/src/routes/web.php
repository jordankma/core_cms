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
            Route::get('manage', 'DocumentCateController@manage')->where('as', 'Quản lý danh mục tài liệu')->name('dhcd.document.cate.manage');
            Route::get('add', 'DocumentCateController@add')->name('dhcd.document.cate.add');
            Route::post('create', 'DocumentCateController@create')->name('dhcd.document.cate.create');
            Route::get('data', 'DocumentCateController@data')->name('dhcd.document.cate.data');
            Route::get('edit', 'DocumentCateController@edit')->name('dhcd.document.cate.edit');
            Route::post('update}', 'DocumentCateController@update')->name('dhcd.document.cate.update');
            Route::get('delete', 'DocumentCateController@delete')->name('dhcd.document.cate.delete');
            Route::get('log', 'DocumentCateController@log')->name('dhcd.document.cate.log');
        });
        
         Route::group(['prefix' => 'dhcd/document/type'], function () {           
            Route::get('edit', 'DocumentTypeController@edit')->where('as', 'Cấu hình kiểu tài liệu')->name('dhcd.document.type.edit');
            Route::post('update}', 'DocumentTypeController@update')->name('dhcd.document.type.update');            
        });
        
        Route::group(['prefix' => 'dhcd/document/doc'], function () {
            Route::get('manage', 'DocumentController@manage')->where('as', 'Quản lý tài liệu')->name('dhcd.document.doc.manage');
            Route::get('add', 'DocumentController@add')->name('dhcd.document.doc.add');
            Route::post('create', 'DocumentController@create')->name('dhcd.document.doc.create');
            Route::get('data', 'DocumentController@data')->name('dhcd.document.doc.data');
            Route::get('edit', 'DocumentController@edit')->name('dhcd.document.doc.edit');
            Route::post('update}', 'DocumentController@update')->name('dhcd.document.doc.update');
            Route::get('delete', 'DocumentController@delete')->name('dhcd.document.doc.delete');
            Route::get('log', 'DocumentController@log')->name('dhcd.document.doc.log');
        });
        
    });
});
<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/topic/topic/log', 'TopicController@log')->name('dhcd.topic.topic.log');
        Route::get('dhcd/topic/topic/data', 'TopicController@data')->name('dhcd.topic.topic.data');
        Route::get('dhcd/topic/topic/manage', 'TopicController@manage')->name('dhcd.topic.topic.manage');
        Route::get('dhcd/topic/topic/create', 'TopicController@create')->name('dhcd.topic.topic.create');
        Route::post('dhcd/topic/topic/add', 'TopicController@add')->name('dhcd.topic.topic.add');
        Route::get('dhcd/topic/topic/show', 'TopicController@show')->name('dhcd.topic.topic.show');
        Route::put('dhcd/topic/topic/update', 'TopicController@update')->name('dhcd.topic.topic.update');
        Route::get('dhcd/topic/topic/delete', 'TopicController@delete')->name('dhcd.topic.topic.delete');
        Route::get('dhcd/topic/topic/confirm-delete', 'TopicController@getModalDelete')->name('dhcd.topic.topic.confirm-delete');
    });
});
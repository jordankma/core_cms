<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('dhcd/news/news/log', 'NewsController@log')->name('dhcd.news.news.log');
        Route::get('dhcd/news/news/data', 'NewsController@data')->name('dhcd.news.news.data');
        Route::get('dhcd/news/news/manager', 'NewsController@manager')->name('dhcd.news.news.manager')->where('as','Quản lý tin tức');
        Route::get('dhcd/news/news/create', 'NewsController@create')->name('dhcd.news.news.create');
        Route::post('dhcd/news/news/add', 'NewsController@add')->name('dhcd.news.news.add');
        Route::get('dhcd/news/news/show/{news_id}', 'NewsController@show')->where('news_id', '[0-9]+')->name('dhcd.news.news.show');
        Route::post('dhcd/news/news/update/{news_id}', 'NewsController@update')->where('news_id', '[0-9]+')->name('dhcd.news.news.update');
        Route::get('dhcd/news/news/delete', 'NewsController@delete')->name('dhcd.news.news.delete');
        Route::get('dhcd/news/news/confirm-delete', 'NewsController@getModalDelete')->name('dhcd.news.news.confirm-delete');

        Route::get('dhcd/news/news/alias', 'NewsController@alias')->name('dhcd.news.news.alias');
        //route news cat
        Route::get('dhcd/news/cat/log', 'NewsCatController@log')->name('dhcd.news.cat.log');
        Route::get('dhcd/news/cat/data', 'NewsCatController@data')->name('dhcd.news.cat.data');
        Route::get('dhcd/news/cat/manager', 'NewsCatController@manager')->name('dhcd.news.cat.manager')->where('as','Quản lý danh mục');
        Route::get('dhcd/news/cat/create', 'NewsCatController@create')->name('dhcd.news.cat.create');
        Route::post('dhcd/news/cat/add', 'NewsCatController@add')->name('dhcd.news.cat.add');
        Route::get('dhcd/news/cat/show', 'NewsCatController@show')->where('news_cat_id', '[0-9]+')->name('dhcd.news.cat.show');
        Route::post('dhcd/news/cat/update', 'NewsCatController@update')->where('news_cat_id', '[0-9]+')->name('dhcd.news.cat.update');
        Route::get('dhcd/news/cat/delete', 'NewsCatController@delete')->name('dhcd.news.cat.delete');
        Route::get('dhcd/news/cat/confirm-delete', 'NewsCatController@getModalDelete')->name('dhcd.news.cat.confirm-delete');

        //route new tag 
        Route::get('dhcd/news/tag/log', 'NewsTagController@log')->name('dhcd.news.tag.log');
        Route::get('dhcd/news/tag/data', 'NewsTagController@data')->name('dhcd.news.tag.data');
        Route::get('dhcd/news/tag/manager', 'NewsTagController@manager')->name('dhcd.news.tag.manager')->where('as','Quản lý tag');
        Route::get('dhcd/news/tag/create', 'NewsTagController@create')->name('dhcd.news.tag.create');
        Route::post('dhcd/news/tag/add', 'NewsTagController@add')->name('dhcd.news.tag.add');
        Route::get('dhcd/news/tag/show', 'NewsTagController@show')->where('news_id', '[0-9]+')->name('dhcd.news.tag.show');
        Route::post('dhcd/news/tag/update', 'NewsTagController@update')->where('news_id', '[0-9]+')->name('dhcd.news.tag.update');
        Route::get('dhcd/news/tag/delete', 'NewsTagController@delete')->name('dhcd.news.tag.delete');
        Route::get('dhcd/news/tag/confirm-delete', 'NewsTagController@getModalDelete')->name('dhcd.news.tag.confirm-delete');

        Route::post('dhcd/news/tag/ajax/add', 'NewsTagController@addAjax')->name('dhcd.news.tag.ajax.add');


    });
});
        //api
    Route::group(array('prefix' => 'dev'), function() {
        Route::get('get/news', 'ApiNewsController@getNews')->name('dhcd.news.news.api.news');
        Route::get('get/news-home', 'ApiNewsController@getNewsHome')->name('dhcd.news.news.api.news.home');
        Route::get('get/detail-new', 'ApiNewsController@getNewsDetail')->name('dhcd.news.news.api.news.detail');
    });
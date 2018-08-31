<?php

$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {  
    Route::group(['prefix' => 'tai-lieu'], function () {
       Route::get('{alias_cate}', 'FileDocumentController@getFileDocument')->where('as', 'Danh mục tài liệu')->name('dhcd.filedoc.getFileDocument');
       Route::get('{alias_cate}/{alias}', 'FileDocumentController@DocumentDetail')->name('dhcd.filedoc.DocumentDetail');
    });
});

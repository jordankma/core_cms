<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        //member
        Route::get('dhcd/member/member/log', 'MemberController@log')->name('dhcd.member.member.log');
        Route::get('dhcd/member/member/data', 'MemberController@data')->name('dhcd.member.member.data');
        Route::get('dhcd/member/member/manage', 'MemberController@manage')->name('dhcd.member.member.manage');
        Route::get('dhcd/member/member/create', 'MemberController@create')->name('dhcd.member.member.create');
        Route::post('dhcd/member/member/add', 'MemberController@add')->name('dhcd.member.member.add');
        Route::get('dhcd/member/member/show', 'MemberController@show')->name('dhcd.member.member.show');
        Route::post('dhcd/member/member/update', 'MemberController@update')->name('dhcd.member.member.update');
        Route::get('dhcd/member/member/delete', 'MemberController@delete')->name('dhcd.member.member.delete');
        Route::get('dhcd/member/member/confirm-delete', 'MemberController@getModalDelete')->name('dhcd.member.member.confirm-delete');
        Route::get('dhcd/member/member/block', 'MemberController@block')->name('dhcd.member.member.block');
        Route::get('dhcd/member/member/confirm-block', 'MemberController@getModalBlock')->name('dhcd.member.member.confirm-block');

        Route::post('dhcd/member/member/check-username-exist', 'MemberController@checkUserNameExist')->name('dhcd.member.member.check-username-exist');
        Route::post('dhcd/member/member/check-email-exist', 'MemberController@checkEmailExist')->name('dhcd.member.member.check-email-exist');
        Route::post('dhcd/member/member/check-phone-exist', 'MemberController@checkPhoneExist')->name('dhcd.member.member.check-phone-exist');

        Route::get('dhcd/member/member/excel/get/import', 'MemberController@getImport')->name('dhcd.member.member.excel.get.import');
        Route::post('dhcd/member/member/excel/post/import', 'MemberController@postImport')->name('dhcd.member.member.excel.post.import');
    });
});
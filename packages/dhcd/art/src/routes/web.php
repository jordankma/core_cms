<?php
$adminPrefix = config('site.admin_prefix');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
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

        Route::get('dhcd/art/member/profile', 'ArtController@memberProfile');


        Route::get('dhcd/art/seed/document',function(){
            DB::table('package_document_types')->insert([[
            'document_type_id' => 1,
            'name' => 'Hình ảnh',
            'type' => 'image',
            'extentions' => json_encode(['image/jpeg','image/jpg','image/png','image/gif'])
        ],[
            'document_type_id' => 2,
            'name' => 'Văn bản',
            'type' => 'text',
            'extentions' => json_encode(['docx','doc','xls','xlsx','pdf'])
        ],[
            'document_type_id' => 3,
            'name' => 'Video',
            'type' => 'video',
            'extentions' => json_encode(['mp4'])
        ],[
            'document_type_id' => 4,
            'name' => 'Audio',
            'type' => 'audio',
            'extentions' => json_encode(['mp3'])
        ]]);
            echo 'done';
        });
        Route::get('dhcd/art/test',function(){
            $string_e = my_simple_crypt('TlUrQXNSeUtiUndQTGVuMGRjdEg0UT09','d');
            echo $string_e;
        });
        function my_simple_crypt( $string, $action = 'e' ) {
            // you may change these values to your own
            $secret_key = 't+m:*meo6h}b?{~';
            $secret_iv = '*[Py49<>n@-VYr1';
            $output = false;
            $encrypt_method = "AES-256-CBC";
            $key = substr( hash( 'sha256', $secret_key ), 0 ,32);
            $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
            if( $action == 'e' ) {
                $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
            }
            else if( $action == 'd' ){
                $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
            }
            return $output;
        }
        
        
    });
});
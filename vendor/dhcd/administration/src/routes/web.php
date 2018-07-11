<?php
$adminPrefix = config('site.admin_prefix');
use Illuminate\Support\Facades\DB;
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        
        //phuong xa
        Route::get('dhcd/administration/commune-guild/log', 'CommuneGuildController@log')->name('dhcd.administration.commune-guild.log');
        Route::get('dhcd/administration/commune-guild/data', 'CommuneGuildController@data')->name('dhcd.administration.commune-guild.data');
        Route::get('dhcd/administration/commune-guild/manage', 'CommuneGuildController@manage')->name('dhcd.administration.commune-guild.manage');
        Route::get('dhcd/administration/commune-guild/create', 'CommuneGuildController@create')->name('dhcd.administration.commune-guild.create');
        Route::post('dhcd/administration/commune-guild/add', 'CommuneGuildController@add')->name('dhcd.administration.commune-guild.add');
        Route::get('dhcd/administration/commune-guild/show', 'CommuneGuildController@show')->name('dhcd.administration.commune-guild.show');
        Route::post('dhcd/administration/commune-guild/update', 'CommuneGuildController@update')->name('dhcd.administration.commune-guild.update');
        Route::get('dhcd/administration/commune-guild/delete', 'CommuneGuildController@delete')->name('dhcd.administration.commune-guild.delete');
        Route::get('dhcd/administration/commune-guild/confirm-delete', 'CommuneGuildController@getModalDelete')->name('dhcd.administration.commune-guild.confirm-delete');
        //quan huyen
        Route::get('dhcd/administration/country-district/log', 'CountryDistrictController@log')->name('dhcd.administration.country-district.log');
        Route::get('dhcd/administration/country-district/data', 'CountryDistrictController@data')->name('dhcd.administration.country-district.data');
        Route::get('dhcd/administration/country-district/manage', 'CountryDistrictController@manage')->name('dhcd.administration.country-district.manage');
        Route::get('dhcd/administration/country-district/create', 'CountryDistrictController@create')->name('dhcd.administration.country-district.create');
        Route::post('dhcd/administration/country-district/add', 'CountryDistrictController@add')->name('dhcd.administration.country-district.add');
        Route::get('dhcd/administration/country-district/show', 'CountryDistrictController@show')->name('dhcd.administration.country-district.show');
        Route::post('dhcd/administration/country-district/update', 'CountryDistrictController@update')->name('dhcd.administration.country-district.update');
        Route::get('dhcd/administration/country-district/delete', 'CountryDistrictController@delete')->name('dhcd.administration.country-district.delete');
        Route::get('dhcd/administration/country-district/confirm-delete', 'CountryDistrictController@getModalDelete')->name('dhcd.administration.country-district.confirm-delete');
        Route::post('dhcd/administration/country-district/check-code', 'CountryDistrictController@checkCode')->name('dhcd.administration.country-district.check-code');
        //tinh thanh pho
        Route::get('dhcd/administration/provine-city/log', 'ProvineCityController@log')->name('dhcd.administration.provine-city.log');
        Route::get('dhcd/administration/provine-city/data', 'ProvineCityController@data')->name('dhcd.administration.provine-city.data');
        Route::get('dhcd/administration/provine-city/manage', 'ProvineCityController@manage')->name('dhcd.administration.provine-city.manage');
        Route::get('dhcd/administration/provine-city/create', 'ProvineCityController@create')->name('dhcd.administration.provine-city.create');
        Route::post('dhcd/administration/provine-city/add', 'ProvineCityController@add')->name('dhcd.administration.provine-city.add');
        Route::get('dhcd/administration/provine-city/show', 'ProvineCityController@show')->name('dhcd.administration.provine-city.show');
        Route::post('dhcd/administration/provine-city/update', 'ProvineCityController@update')->name('dhcd.administration.provine-city.update');
        Route::get('dhcd/administration/provine-city/delete', 'ProvineCityController@delete')->name('dhcd.administration.provine-city.delete');
        Route::get('dhcd/administration/provine-city/confirm-delete', 'ProvineCityController@getModalDelete')->name('dhcd.administration.provine-city.confirm-delete');
        Route::post('dhcd/administration/provine-city/check-code', 'ProvineCityController@checkCode')->name('dhcd.administration.provine-city.check-code');

        Route::get('dhcd/administration/country-district/member', 'CountryDistrictController@getCountryDistrict')->name('dhcd.administration.country-district.member');
    });
});
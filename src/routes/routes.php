<?php

Route::group(['namespace' => 'YoweliKachala\PackageGenerator\Controllers'], function()
{
    Route::get('project', ['uses' => 'PackageGeneratorController@index']);
    Route::post('add', ['uses' => 'PackageGeneratorController@add']);
    Route::post('add-module', ['uses' => 'PackageGeneratorController@addModule']);
    Route::get('finish', ['uses' => 'PackageGeneratorController@finish']);
    Route::post('delete-module', ['uses' => 'PackageGeneratorController@deleteModule']);
});
<?php

Route::group(['namespace' => 'YoweliKachala\PackageGenerator\Controllers'], function()
{
    Route::get('project', ['uses' => 'PackageGeneratorController@index']);
    Route::get('create-project', ['uses' => 'PackageGeneratorController@create']);
});
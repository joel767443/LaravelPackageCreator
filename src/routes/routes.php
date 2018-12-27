<?php

Route::group(['namespace' => 'YoweliKachala\PackageGenerator\Controllers'], function()
{
    Route::get('project', ['uses' => 'PackageGeneratorController@index']);
    Route::get('finish', ['uses' => 'PackageGeneratorController@finish']);
});
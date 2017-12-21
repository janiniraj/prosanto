<?php

Route::group([
    'namespace'  => 'Device',
], function () {

    /*
     * Admin Event Controller
     */
    //Route::resource('device', 'DeviceController');

    Route::get('/device', 'DeviceController@index')->name('device.index');
    Route::get('/device/get', 'DeviceController@getTableData')->name('device.get-list-data');
    Route::get('/device/{device}/edit', 'DeviceController@edit')->name('device.edit');
    Route::patch('/device/{device}/update', 'DeviceController@update')->name('device.update');
    Route::delete('/device/{device}/destroy', 'DeviceController@destroy')->name('device.destroy');
});

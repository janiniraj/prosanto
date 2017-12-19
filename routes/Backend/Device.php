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
});

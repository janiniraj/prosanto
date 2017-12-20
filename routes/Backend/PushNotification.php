<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::get('pushnotification', 'PushNotificationController@index')->name('pushnotification');
Route::post('pushnotification', 'PushNotificationController@sendNotification')->name('pushnotification.sendnotification');
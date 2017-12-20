<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

/**
 * Class PushNotificationController.
 */
class PushNotificationController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.pushnotification.index');
    }

    public function sendnotification()
    {
        return redirect()->route('admin.pushnotification')->withFlashSuccess("Push Notification sent successfully.");
    }
}

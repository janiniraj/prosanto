<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device\Device;

/**
 * Class PushNotificationController.
 */
class PushNotificationController extends Controller
{
    /**
     * PushNotificationController constructor.
     */
    public function __construct()
    {
        $this->device = new Device();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.pushnotification.index');
    }

    public function sendnotification(Request $request)
    {
        $postData = $request->all();

        define( 'API_ACCESS_KEY', 'AAAA6gmtRhc:APA91bG3c5G8NOGNReDpCdWfFnSW_IaDdyBZTGJR67K9tfQm3Om7EO5K2fVmqUBjD7FHsC3iPtQ6j8kCdR43KNoZK-fdprfZeXo8jnCT51JSlKjlGoXO9Xa5LH2uSP0lfjkJQCtQV443' );

        if($postData['device_type'] == 'android')
        {
            $tokens = $this->device->where('devicetype', 'android')->pluck('token')->toArray();
        }
        elseif ($postData['device_type'] == 'ios')
        {
            $tokens = $this->device->where('devicetype', 'ios')->pluck('token')->toArray();
        }
        else
        {
            $tokens = $this->device->pluck('token')->toArray();
        }
        $fcmMsg = array(
            'body' => $postData['message'],
            'title' => '',
            'sound' => "default"
        );

        $fcmFields = array(
            'registration_ids' => $tokens,
            'priority' => 'high',
            'notification' => $fcmMsg
        );

        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return redirect()->route('admin.pushnotification')->withFlashSuccess("Push Notification sent successfully.");
    }
}

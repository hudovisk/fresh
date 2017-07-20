<?php

namespace App\Helpers;

use App\Channels\FCMMessage;

class FirebaseHelper {

    private $notificationsUrl;
    private $pushKey;

    public function __construct() {
        $this->notificationsUrl = 'https://fcm.googleapis.com/fcm/send';
        $this->pushKey = config('services.firebase.push_key');
    }

    public function sendNotification(FCMMessage $message, $to) {

        if(!$to) return false;

        if(is_array($to) && count($to) > 0) {
            $data = array_merge([
                'registration_ids' => $to
            ], $message->getPayload());

        } else {
            $data = array_merge([
                'to' => $to
            ], $message->getPayload());
        }

        $auth = 'key=' . $this->pushKey;

        return CurlHelper::sendJsonPost($this->notificationsUrl, $data, $auth);
    }
}

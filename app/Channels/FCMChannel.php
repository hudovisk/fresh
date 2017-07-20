<?php

namespace App\Channels;

use App\Helpers\FirebaseHelper;
use Illuminate\Notifications\Notification;

/**
 * Created by PhpStorm.
 * User: Aluno
 * Date: 19/07/2017
 * Time: 19:54
 */
class FCMChannel
{

    const MAX_NOTIFICATIONS = 1000;

    private $firebaseHelper;

    public function __construct(FirebaseHelper $firebaseHelper)
    {
        $this->firebaseHelper = $firebaseHelper;
    }

    public function send($notifiable, Notification $notification) {

        $gcmMessage = $notification->toFCM();

        if(is_array($notifiable)) {
            $tokens = array_chunk($notifiable, self::MAX_NOTIFICATIONS);

            foreach ($tokens as $registered_ids) {
                $this->firebaseHelper->sendNotification($gcmMessage, $registered_ids);
            }
        } else if($notifiable) {
            $this->firebaseHelper->sendNotification($gcmMessage, $notifiable);
        }
    }

}
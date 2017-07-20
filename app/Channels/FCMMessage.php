<?php
/**
 * Created by PhpStorm.
 * User: Aluno
 * Date: 19/07/2017
 * Time: 20:54
 */

namespace App\Channels;


class FCMMessage
{

    public $title;

    public $message;

    public $bigImageUrl;

    public $action;

    public $customData;

    public $isDataMessage = false;

    public function title($title) {
        $this->title = $title;

        return $this;
    }

    public function message($message) {
        $this->message = $message;

        return $this;
    }

    public function bigImageUrl($bigImageUrl) {
        $this->bigImageUrl = $bigImageUrl;

        return $this;
    }

    public function action($action) {
        $this->action = $action;

        return $this;
    }

    public function isDataMessage($isDataMessage) {
        $this->isDataMessage = $isDataMessage;

        return $this;
    }

    public function customData(array $customData) {
        $this->customData = $customData;

        return $this;
    }

    public function getPayload() {

        $payload = [];

        if($this->isDataMessage) {
            $payload['data'] = array_merge([
                'title' => $this->title,
                'message' => $this->message,
                'image_url' => $this->bigImageUrl,
                'action' => $this->action
            ], $this->customData);
        } else {
            $payload['notification'] = [
                'title' => $this->title,
                'body' => $this->message
            ];
        }

        return $payload;
    }
}
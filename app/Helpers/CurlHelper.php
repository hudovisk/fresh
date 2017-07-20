<?php

namespace App\Helpers;

class CurlHelper {

    public static function sendJsonPost($url, $data, $authorization = null) {

        $data = json_encode($data);

        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        );

        if(isset($authorization)) array_push($headers, 'Authorization: ' . $authorization);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $resultJson = json_decode( $result );

        return $resultJson ?: $result;
    }

    public static function sendJsonPut($url, $data, $authorization = null) {

        $data = json_encode($data);

        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        );

        if(isset($authorization)) array_push($headers, 'Authorization: ' . $authorization);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $resultJson = json_decode( $result );

        return $resultJson ?: $result;
    }

}

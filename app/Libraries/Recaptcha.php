<?php

namespace App\Libraries;

use Config\Services;

class Recaptcha
{
    private $secret_key;
    private $url;
    public function __construct()
    {
        $this->secret_key = env('SECRET_KEY_RECAPTCHA');
        $this->url = 'https://www.google.com/recaptcha/api/siteverify';
    }
    public function verify($data)
    {
        $data1 = array('secret' => $this->secret_key, 'response' => $data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response, true);
        if ($status['success']) {
            return true;
        } else {
            return false;
        }
    }
}
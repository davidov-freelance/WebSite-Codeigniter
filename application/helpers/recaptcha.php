<?php

class ReCaptcha_Helper extends CI_Controller {

    public $google_url="https://www.google.com/recaptcha/api/siteverify";
    public  $secret='6Le9rhMTAAAAAI1VGgvSevwQrnl8uEjBaAV1NoAp';


    public function sendRequest($recaptcha){
        $ip=$_SERVER['REMOTE_ADDR'];
        $url = $this->google_url."?secret=".$this->secret."&response=".$recaptcha."&remoteip=".$ip;
        $res=$this->getCurlData($url);
        $res= json_decode($res, true);
        if($res['success']) {
           return true;
        } else {
            return false;
        }

    }


    public function getCurlData( $url )
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }


}
<?php


namespace App\Helper;


class Rechaptcha
{

    public static function valid($rechaptcha)
    {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
            'secret' => env('PRIVATE_KEY'),
            'response' => $rechaptcha,
            'remoteip' => $remoteip
        ];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);

        if ($resultJson->success != true) {
//                return back()->withErrors(['captcha' => 'ReCaptcha Error']);
            return false;
        }
        if ($resultJson->score >= 0.3) {
            //Validation was successful, add your form submission logic here
//                return back()->with('message', 'Thanks for your message!');
            return true;
        } else {
//                return back()->withErrors(['captcha' => 'ReCaptcha Error']);
            return false;
        }
    }
}

<?php

namespace App\Helpers;

use App\Models\Notifications;
use Carbon\Carbon;
use GuzzleHttp\Exception\ConnectException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Intervention\Image\ImageManagerStatic as Image;
use FCM;

/**
 * Class Helpers
 * @package App\Helpers
 */
trait Functions
{

    public function whatsapp($phone , $bode){

        $whatsappToken = config('services.whatsapp.token');
        $whatsappInstance = config('services.whatsapp.instance');

        $params=array(
            'token' => $whatsappToken,
            'to' => $phone,
            'body' =>$bode,

        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/{$whatsappInstance}/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

    }

}

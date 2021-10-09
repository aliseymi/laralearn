<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class GhasedakChannel
{
    public function send($notifiable, Notification $notification)
    {

        if(!method_exists($notification,'toGhasedakSms')){
            throw new \Exception('toGhasedakSms not found!');
        }

        $data = $notification->toGhasedakSms($notifiable);
        $message = $data['text'];
        $receptor = $data['phone_number'];
        $api_key = config('services.ghasedak.key');
        try {
            $lineNumber = "30005006006528";
            $api = new \Ghasedak\GhasedakApi($api_key);
            $api->SendSimple($receptor, $message,$lineNumber);
        } catch (\Ghasedak\Exceptions\ApiException $e) {
            throw $e;
        } catch (\Ghasedak\Exceptions\HttpException $e) {
            throw $e;
        }
    }
}

<?php

namespace App\Notifications;

use App\Notifications\Channels\GhasedakChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActiveCode extends Notification
{
    use Queueable;

    public $code;
    public $phone_number;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code,$phone_number)
    {
        $this->code = $code;
        $this->phone_number = $phone_number;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [GhasedakChannel::class];
    }

    public function toGhasedakSms($notifiable)
    {
        return [
            'text' => "وبسایت آموزشی لارالرن\n کد احراز هویت شما: {$this->code}",
            'phone_number' => $this->phone_number
        ];
    }

}

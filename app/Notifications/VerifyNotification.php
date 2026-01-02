<?php

namespace App\Notifications;

use App\Channels\VerifySmsChannel;
use App\Services\CodeService\VerifyCodeService;
use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class VerifyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery Channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        VerifyCodeService::store($notifiable->id, VerifyCodeService::generate());

        return [];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toSms(object $notifiable): void
    {
        $code = VerifyCodeService::get($notifiable->id);


        // GhasedakFacade::Verify($notifiable->mobile, "otpCode", $code);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'کد تایید ارسال شد',
            'code' => VerifyCodeService::get($notifiable->id)
        ];
    }
}

<?php

namespace App\Listeners;

use App\Notifications\VerifyNotification;
use Illuminate\Support\Facades\Notification;


class VerificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Notification::send($event->user, new VerifyNotification());
    }
}

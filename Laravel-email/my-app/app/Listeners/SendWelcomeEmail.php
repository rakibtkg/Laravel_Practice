<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeEmail implements ShouldQueue
{
    public function handle(Registered $event)
    {
        if ($event->user && $event->user->email) {
            Mail::to($event->user->email)->send(new WelcomeMail($event->user));
        }
    }
}

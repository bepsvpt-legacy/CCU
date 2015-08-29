<?php

namespace App\Listeners\Member;

use App\Events\Member\RegisterEvent;
use App\Ccu\Mail\Register;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification //implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        $mail = new Register($event->account);

        $mail->send();
    }
}

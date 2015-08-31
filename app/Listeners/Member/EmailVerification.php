<?php

namespace App\Listeners\Member;

use App\Events\Member\RegisterEvent;
use App\Ccu\Mail\Register;

class EmailVerification
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

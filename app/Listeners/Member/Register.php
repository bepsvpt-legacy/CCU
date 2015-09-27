<?php

namespace App\Listeners\Member;

use App\Ccu\General\Event;
use App\Events\Member\Register as RegisterEvent;

class Register
{
    /**
     * Handle the event.
     *
     * @param  RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        Event::_create('events.account', $event->account, 'account.register');
    }
}

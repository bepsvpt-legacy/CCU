<?php

namespace App\Listeners\Member;

use App\Ccu\General\Category;
use App\Ccu\General\Event;
use Illuminate\Events\Dispatcher;

class AccountEventListener
{
    /**
     * Handle account register events.
     *
     * @param \App\Events\Member\RegisterEvent $event
     */
    public function onRegister($event)
    {
        $this->logEvents($event, 'account.register');
    }

    /**
     * Handle account sign in events.
     *
     * @param \App\Events\Member\SignInEvent $event
     */
    public function onSignIn($event)
    {
        $this->logEvents($event, 'account.signIn');
    }

    /**
     * Log account events.
     *
     * @param \App\Events\Member\RegisterEvent|\App\Events\Member\SignInEvent $event
     * @param string $action
     */
    public function logEvents($event, $action)
    {
        Event::create([
            'category_id' => Category::getCategories('events.account', true),
            'account_id' => $event->account->getAttribute('id'),
            'action' => $action,
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     * @return array
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'App\Events\Member\RegisterEvent',
            'App\Listeners\Member\AccountEventListener@onRegister'
        );

        $events->listen(
            'App\Events\Member\RegisterEvent',
            'App\Listeners\Member\EmailVerification@handle'
        );

        $events->listen(
            'App\Events\Member\SignInEvent',
            'App\Listeners\Member\AccountEventListener@onSignIn'
        );
    }
}

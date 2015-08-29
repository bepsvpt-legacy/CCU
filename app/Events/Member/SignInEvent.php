<?php

namespace App\Events\Member;

use App\Ccu\Member\Account;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class SignInEvent extends Event
{
    use SerializesModels;

    /**
     * @var Account
     */
    public $account;

    /**
     * Create a new event instance.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}

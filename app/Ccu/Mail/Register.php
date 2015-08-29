<?php

namespace App\Ccu\Mail;

use App\Ccu\General\Category;
use App\Ccu\General\Verify;
use Carbon\Carbon;
use App\Ccu\Member\Account;

class Register extends MailerAbstract
{
    /**
     * @var \App\Ccu\Member\Account
     */
    private $account;

    /**
     * @var int
     */
    private $category;

    /**
     * Create a new register instance.
     *
     * @param \App\Ccu\Member\Account $account
     */
    public function __construct(Account $account)
    {
        $this->to = $account->getAttribute('email');

        $this->account = $account;

        $this->category = Category::getCategories('verifies.account', true);

        $this->make();
    }

    protected function make()
    {
        $this->expireOldTokens($this->category, $this->account->getAttribute('id'));

        $verify = Verify::create([
            'token' => str_random(100),
            'category_id' => $this->category,
            'account_id' => $this->account->getAttribute('id'),
            'created_at' => Carbon::now()
        ]);

        $this->data = [
            'token' => $verify->getAttribute('token')
        ];
    }

    /**
     * Get email subject.
     */
    public function getSubject()
    {
        return env('DOMAIN') . ' - 註冊驗證信';
    }

    /**
     * Get view.
     */
    public function getView()
    {
        return 'emails.register';
    }

    /**
     * Get source email address.
     */
    public function getFromEmail()
    {
        return 'noreply@mail.bepsvpt.net';
    }
}
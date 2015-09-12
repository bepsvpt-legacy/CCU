<?php

namespace App\Ccu\Mail;

use App\Ccu\General\Verify;
use Mail;

abstract class MailerAbstract
{
    /**
     * Destination mail address.
     *
     * @var string
     */
    protected $to = 'support@mail.bepsvpt.net';

    /**
     * Data to pass to view.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var int
     */
    protected $tokenLength = 100;

    /**
     * Send a new message using a view.
     *
     * @return mixed
     */
    public function send()
    {
        return Mail::send($this->getView(), $this->getData(), function ($message) {
            $message->from($this->getFromEmail());

            $message->subject($this->getSubject());

            $message->to($this->getToEmail());
        });
    }

    /**
     * Expire old verify tokens.
     *
     * @param int $categoryId
     * @param int $accountId
     * @return bool|null
     */
    protected function expireOldTokens($categoryId, $accountId)
    {
        return Verify::where('category_id', '=', $categoryId)->where('account_id', '=', $accountId)->delete();
    }

    /**
     * Get destination email address.
     *
     * @return string
     */
    public function getToEmail()
    {
        return $this->to;
    }

    /**
     * Get view data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *  Get email subject.
     */
    public function getSubject()
    {
        return env('DOMAIN');
    }

    /**
     * Get view.
     *
     * @return string
     */
    abstract public function getView();

    /**
     * Get source email address.
     *
     * @return string
     */
    abstract public function getFromEmail();
}

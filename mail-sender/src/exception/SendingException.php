<?php


namespace MailSender\exception;


use Exception;

class SendingException extends Exception
{
    const CODE = 4000;

    public function __construct($message, $code = self::CODE)
    {
        $message = strip_tags($message); // remove tags from php mailer
        // exceptions.
        parent::__construct($message, $code);
    }

}
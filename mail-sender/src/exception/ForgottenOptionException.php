<?php


namespace MailSender\exception;


use Exception;

class ForgottenOptionException extends Exception
{
    const CODE = 5000;

    public function __construct($message, $code = self::CODE)
    {
        parent::__construct($message, $code);
    }
}
<?php


namespace MailSender\exception;


use Exception;

class EmailValidationException extends Exception
{
    const CODE = 3000;

    public function __construct($mail, $mailType, $code = self::CODE)
    {
        $message = "value ($mail) provided for {$mailType} is not valid.";
        parent::__construct($message, $code);
    }
}
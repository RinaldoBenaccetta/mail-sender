<?php


namespace MailSender\exception;


use Exception;

class SettingsException extends Exception
{
    const CODE = 1000;

    public function __construct($value, $code = self::CODE)
    {
        $message = "Encryption method should be STARTTLS or SMTPS : {$value} given";
        parent::__construct($message, $code);
    }
}
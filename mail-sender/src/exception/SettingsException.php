<?php


namespace MailSender\exception;


use Exception;

class SettingsException extends Exception
{
    const CODE = 1000;

    public function __construct($message, $code = 8012)
    {
        parent::__construct($message, $code);
    }
}
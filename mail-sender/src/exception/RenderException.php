<?php


namespace MailSender\exception;


use Exception;

class RenderException extends Exception
{
    const CODE = 2000;
    const MESSAGE = 'There was an error with the template engine : ';

    public function __construct($message = self::MESSAGE, $code = self::CODE)
    {
        parent::__construct(self::MESSAGE . $message, $code);
    }

}
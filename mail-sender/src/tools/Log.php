<?php


namespace MailSender\tools;

use MailSender\Path;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log

{
    private const LOG_DIRECTORY = "/log/";

    public function __construct($data)
    {
        return $this->init($data);
    }

    private function init($data) {
        // Create the logger
        $logger = new Logger('my_logger');
        // Now add some handlers
        $logger->pushHandler(new StreamHandler(Path::ROOT_PATH .
                                               self::LOG_DIRECTORY.'log.log',
                                               Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());

        // You can now use your logger
        $logger->info($data);

        return $logger;
    }




}
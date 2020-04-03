<?php


namespace MailSender\tools;

use MailSender\Path;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log

{
    /**
     * Directory of log file.
     */
    private const LOG_DIRECTORY = "/../log/";

    /**
     * Channel for log.
     */
    private const DEFAULT_CHANNEL = "mail-sender";

    /**
     * The list of severity of exceptions.
     */
    private const SEVERITY_LIST = [
        'debug',
        'info',
        'notice',
        'warning',
        'error',
        'critical',
        'alert',
        'emergency',
    ];

    /**
     * Log constructor.
     *
     * @param        $severity
     * @param        $data
     * @param string $channel
     */
    public function __construct(
        $severity,
        $data,
        $channel = self::DEFAULT_CHANNEL
    ) {
        return $this->init($severity, $data, $channel);
    }

    /**
     * Create a log in the log file.
     *
     * @param $severity
     * @param $data
     * @param $channel
     * @return Logger
     */
    private function init($severity, $data, $channel)
    {
        // filter $severity.
        $severity = $this->filterSeverity($severity);
        // Create the logger
        $logger = new Logger($channel);
        // Now add some handlers
        $logger->pushHandler(
            new StreamHandler(
                Path::ROOT_PATH .
                self::LOG_DIRECTORY . 'log.log',
                Logger::INFO
            )
        );
        $logger->pushHandler(new FirePHPHandler());

        // pass $severity as function name.
        $logger->$severity($data);

        return $logger;
    }

    /**
     * Check if severity is valid, return the string provided if is it.
     * Return info if not.
     *
     * @param string $severity Severity can be in uppercase or lowercase.
     * @return string
     */
    private function filterSeverity(string $severity): string
    {
        if (!empty($severity) && in_array(
                strtolower($severity),
                self::SEVERITY_LIST
            )) {
            return strtolower($severity);
        }
        return 'info';
    }

}

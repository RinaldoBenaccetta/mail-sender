<?php

namespace MailSender\data;

use MailSender\tools\BoolTool;

/**
 * Class Server
 *
 * @package MailSender\data
 */
class Server implements ServerInterface
{

    /**
     * @var array
     */
    private array $_environment;

    /**
     * Server constructor.
     * @param EnvironmentInterface $environment
     */
    public function __construct(EnvironmentInterface $environment)
    {
        $this->setEnvironmentSettings($environment);
    }

    /**
     * @param EnvironmentInterface $environment
     */
    protected function setEnvironmentSettings(EnvironmentInterface $environment)
    {
        //$environment = new Environment();
        $this->_environment = $environment->getEnvironment();
    }

    /**
     * Return an object with the values to access server
     * provided in the .env file.
     *
     * Use like this :
     *     $server->getServerSettings()->host
     *
     * @return object
     */
    public function getServerSettings(): object
    {
        return (object)[
            'host' => (string)$this->_environment['HOST'],
            'port' => (string)$this->_environment['PORT'],
            'encryption' => (string)$this->_environment['ENCRYPTION'],
            'smtpAuthentication' => BoolTool::toBool($this->_environment['SMTP_AUTHENTICATION']),// transform to bool
            'mailLogin' => (string)$this->_environment['MAIL_LOGIN'],
            'mailPassword' => (string)$this->_environment['MAIL_PASSWORD'],
        ];
    }

}
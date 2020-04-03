<?php


namespace MailSender\data;


use Dotenv\Dotenv;
use MailSender\Path;
use MailSender\tools\BoolTool;

/**
 * Class Environment
 *
 * @package MailSender\data
 */
class Environment implements EnvironmentInterface
{

    /**
     * @var object
     */
    protected object $_settings;

    /**
     *
     * @var array
     */
    protected array $_environment;

    /**
     * Environment constructor.
     *
     * @param object $_settings
     */
    public function __construct(object $_settings)
    {
        $this->setSettings($_settings);
        $this->setEnvironment();
    }

    /**
     * @param object $_settings
     */
    protected function setSettings(object $_settings)
    {
        $this->_settings = $_settings;
    }

    /**
     * Get the variables included in the .env file.
     */
    protected function setEnvironment(): void
    {
        $dotEnv = Dotenv::createImmutable(
            Path::ROOT_PATH . $this->getRootParent()
        );
        $this->_environment = $dotEnv->load();
    }

    /**
     * @return string
     */
    protected function getRootParent(): string
    {
        $repeat = 1 + $this->_settings->global->rootParent;
        if ($repeat < 1) {
            $repeat = 1;
        }
        return str_repeat('/..', $repeat) . '/';
    }

    /**
     * Return an array with the environment variables
     * listed in .env file.
     *
     * @return array
     */
    public function getEnvironment(): array
    {
        return $this->_environment;
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
    public function getEnvironmentObject(): object
    {
        return (object)[
            'host' => (string)$this->_environment['HOST'],
            'port' => (string)$this->_environment['PORT'],
            'encryption' => (string)$this->_environment['ENCRYPTION'],
            'smtpAuthentication' => BoolTool::toBool(
                $this->_environment['SMTP_AUTHENTICATION']
            ),// transform to bool
            'mailLogin' => (string)$this->_environment['MAIL_LOGIN'],
            'mailPassword' => (string)$this->_environment['MAIL_PASSWORD'],
            'mailAlert' => (string)$this->_environment['MAIL_ALERT'],
            'mailAlertSenderMail' => (string)$this->_environment['MAIL_ALERT_SENDER_MAIL'],
            'mailAlertSenderName' => (string)$this->_environment['MAIL_ALERT_SENDER_NAME'],
            'mailAlertRecipientMail' => (string)$this->_environment['MAIL_ALERT_RECIPIENT_MAIL'],
            'mailAlertRecipientName' => (string)$this->_environment['MAIL_ALERT_RECIPIENT_NAME'],
        ];
    }

}
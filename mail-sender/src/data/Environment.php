<?php


namespace MailSender\data;


use Dotenv\Dotenv;
use MailSender\Path;
use MailSender\settings\GetSettings;

/**
 * Class Environment
 *
 * @package MailSender\data
 */
class Environment
{

    /**
     * @var object
     */
    private object $_settings;

    /**
     * @var array
     */
    private array $_environment;


    /**
     * Environment constructor.
     */
    public function __construct()
    {
        $this->setSettings();
        $this->setServer();
    }

    /**
     * @return object
     */
    protected function setSettings(): object
    {
        return $this->_settings = GetSettings::getSettings();
    }

    /**
     * Get the variables included in the .env file.
     */
    protected function setServer(): void
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

}
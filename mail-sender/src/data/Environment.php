<?php


namespace MailSender\data;


use Dotenv\Dotenv;
use MailSender\Path;

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
    private object $_settings;

    /**
     *
     * @var array
     */
    private array $_environment;

    /**
     * Environment constructor.
     *
     * @param object $_settings
     */
    public function __construct(object $_settings)
    {
        $this->setSettings($_settings);
        $this->setServer();
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
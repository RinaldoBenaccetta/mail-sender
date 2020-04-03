<?php

namespace MailSender\data;


/**
 * Class Environment
 *
 * @package MailSender\data
 */
interface EnvironmentInterface
{
    /**
     * Return an array with the environment variables
     * listed in .env file.
     *
     * @return array
     */
    public function getEnvironment(): array;

    /**
     * Return an object with the values to access server
     * provided in the .env file.
     *
     * Use like this :
     *     $server->getServerSettings()->host
     *
     * @return object
     */
    public function getEnvironmentObject(): object;
}
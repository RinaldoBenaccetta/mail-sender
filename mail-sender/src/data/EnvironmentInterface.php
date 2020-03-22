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
}
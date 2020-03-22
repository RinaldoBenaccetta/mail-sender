<?php


namespace MailSender\data;


interface ServerInterface
{

    /**
     * Return an object with the values to access server
     * provided in the .env file.
     *
     * Use like this :
     *     $server->getServerSettings()->host
     *
     * @return object
     */
    public function getServerSettings();
}
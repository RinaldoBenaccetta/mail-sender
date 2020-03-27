<?php


namespace MailSender\response;

use MailSender\tools\Redirect;

/**
 * Class Response
 * Base class for sending back responses.
 *
 * @package MailSender\response
 */
class Response
{

    /**
     * @var object
     */
    protected object $_settings;

    /**
     * Response constructor.
     *
     * @param $settings
     */
    public function __construct($settings)
    {
        $this->setSettings($settings);
    }

    /**
     * @param object $settings
     */
    protected function setSettings(object $settings): void
    {
        $this->_settings = $settings;
    }

    /**
     * Redirect the page to the URL.
     *
     * @param $page
     * @return Redirect
     */
    protected function redirectPage(string $page): Redirect
    {
        return new Redirect($this->_settings, $page);
    }

    /**
     * Check if client value in $_POST is set.
     *
     * @return mixed|null
     */
    protected function client()
    {
        if (!empty($_POST['client'])) {
            return $_POST['client'];
        }
        return null;
    }

}
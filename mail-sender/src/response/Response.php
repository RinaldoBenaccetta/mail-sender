<?php


namespace MailSender\response;

use MailSender\tools\Redirect;
use MailSender\tools\StringTool;

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
     * @param object $settings
     */
    public function __construct(object $settings)
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
     * Check if page would be redirected or not,
     * according to noRedirect value in $_POST.
     * Check directly from $_POST instead of $post because $post can throw
     * error.
     *
     * @return bool
     */
    protected function isRedirected(): bool
    {
        if (isset($_POST['redirect'])) {
            $redirect = StringTool::toSanitizedString($_POST['redirect']);
        } else {
            $redirect = null;
        }

        if (!empty($redirect)) {
            return true;
        }
        return false;
    }

    /**
     * Check if client value in $_POST is set.
     * Check directly from $_POST instead of $post because $post can throw
     * error.
     *
     * @return string|null
     */
    protected function client(): ?string
    {
        if (isset($_POST['client'])) {
            $client = StringTool::toSanitizedString($_POST['client']);
        } else {
            $client = null;
        }

        if (!empty($client) || $client  != 'html') {
            return strtolower($client);
        }
        return null;
    }

}
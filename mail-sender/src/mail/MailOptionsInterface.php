<?php

namespace MailSender\mail;


/**
 * Class MailOptions
 *
 * @package MailSender\mail
 */
interface MailOptionsInterface
{
    /**
     * Return the options for rendering.
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Return the settings of the app.
     *
     * @return object
     */
    public function getSettings(): object;

    /**
     * Return the sanitized and validated $_POST.
     *
     * @return object
     */
    public function getPost(): object ;
}
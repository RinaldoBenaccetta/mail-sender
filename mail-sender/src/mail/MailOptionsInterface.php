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
}
<?php


namespace MailSender\data;


use Exception;

interface PostInterface
{
    /**
     * Get the Post Values sanitized and validated.
     *
     * @return array|null
     * @throws Exception
     */
    public function getPost();
}
<?php


namespace MailSenderTest\data;


use MailSender\data\Environment;

class EnvironmentFixture extends Environment
{

    /**
     * Mock the .env file.
     */
    protected function setEnvironment(): void
    {
        $this->_environment = (array)[
            'HOST' => 'smtp.gmail.com',
            'PORT' => '587',
            'ENCRYPTION' => 'STARTTLS',
            'SMTP_AUTHENTICATION' => true,
            'MAIL_LOGIN' => 'sarah@connor.com',
            'MAIL_PASSWORD' => 'myPassword',
            'MAIL_ALERT' => TRUE,
            'MAIL_ALERT_SENDER_MAIL' => 'T-800@skynet.com',
            'MAIL_ALERT_SENDER_NAME' => 'skynet sender server',
            'MAIL_ALERT_RECIPIENT_MAIL' => 'T-800@skynet.com',
            'MAIL_ALERT_RECIPIENT_NAME' => 'T-800',
        ];
    }

}
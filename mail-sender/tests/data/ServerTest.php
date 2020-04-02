<?php

use MailSender\data\Environment;
use MailSender\data\Server;


class ServerTest extends PHPUnit\Framework\TestCase
{
    public function getServer()
    {
        return (array)[
            "HOST" => "smtp.gmail.com",
            "PORT" => "587",
            "ENCRYPTION" => "STARTTLS",
            "SMTP_AUTHENTICATION" => true,
            "MAIL_LOGIN" => "sarah@connor.com",
            "MAIL_PASSWORD" => "myPassword",
        ];
    }

    public function mockServer()
    {
        $environment = $this->createMock(Environment::class);

        $environment->method('getEnvironment')
            ->willReturn($this->getServer());

        return new Server(($environment));
    }

    public function testGetServer()
    {
        $server = $this->mockServer();
        $settings = $server->getServerSettings();

        $assertNotEmptyValues = $this->assertNotEmptyValues($settings);
        $assertHasKeyServer = $this->assertHasKeyServer($settings);


        $this->assertIsObject($settings);
        $this->assertTrue($assertNotEmptyValues);
        $this->assertTrue($assertHasKeyServer);
    }

    public function assertNotEmptyValues($settings)
    {
        foreach ($settings as $key => $value) {
            if (isset($value) && is_null($value)) {
                return false;
            }
        }
        return true;
    }

    public function assertHasKeyServer($settings)
    {
        $keys = [
            'host',
            'port',
            'encryption',
            'smtpAuthentication',
            'mailLogin',
            'mailPassword'
        ];
        foreach ($keys as $key => $value) {
            if (!property_exists($settings, $value)) {
                return false;
            }
        }
        return true;
    }

}
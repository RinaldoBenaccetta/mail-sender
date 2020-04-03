<?php

use MailSenderTest\data\EnvironmentFixture;
use PHPUnit\Framework\TestCase;


class EnvironmentTest extends TestCase
{
    private EnvironmentFixture $given;

    public function setUp(): void
    {
        // this function is executed before test.
        $this->given = new EnvironmentFixture($this->getSettings());
    }

    public function tearDown(): void
    {
        // this function is executed after the test.
        unset($this->given);
    }

    public function getSettings() {
        return (object) [
            'something' => 'someValue',
        ];
    }

    public function testGetEnvironment()
    {
        $assertNotEmptyValues = $this->assertNotEmptyValues($this->given->getEnvironmentObject());
        $assertHasKeyServer = $this->assertHasKeyServer($this->given->getEnvironmentObject());


        $this->assertIsObject($this->given->getEnvironmentObject());
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
            'mailPassword',
            'mailAlert',
            'mailAlertSenderMail',
            'mailAlertSenderName',
            'mailAlertRecipientMail',
            'mailAlertRecipientName',
        ];
        foreach ($keys as $key => $value) {
            if (!property_exists($settings, $value)) {
                return false;
            }
        }
        return true;
    }

}
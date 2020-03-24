<?php

namespace MailSenderTest\settings;

use MailSender\settings\GetSettings;
use PHPUnit\Framework\TestCase;


class GetSettingsTest extends TestCase
{
    private GetSettingsFixture $given;

    public function setUp(): void
    {
        // this function is executed before test.
        $this->given = new GetSettingsFixture();
    }

    public function tearDown(): void
    {
        // this function is executed after the test.
        unset($this->given);
    }

    public function testGetSettings()
    {
        $expected = $this->getExpected();
        $getSettings = new GetSettings($this->given);
        $value = $getSettings->getSettings();
        $this->assertEquals($expected, $value);
    }

    public function getExpected()
    {
        return (object)[
            "one" => (object)[
                "oneOne" => "1.1",
                "oneTwo" => "1.2",
                "oneThree" => (object)[
                    "oneThreeOne" => "1.3.1",
                    "oneThreeTwo" => "1.3.2",
                ]
            ],
            "two" => (object)[
                "twoOne" => "2.1",
                "twoTwo" => "2.2",
                "twoThree" => (object)[
                    "twoThreeOne" => "2.3.1",
                    "twoThreeTwo" => "2.3.2",
                ]
            ],
            "three" => (object)[
                "threeOne" => "3.1",
                "threeTwo" => "3.2"
            ],
            "four" => "a string"
            // five, six are not here : it is protected or private.
            // testFunction is hot here too, it's not a property.
        ];
    }

}
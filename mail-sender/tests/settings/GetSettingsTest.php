<?php

namespace settings;

use MailSender\settings\GetSettings;
use PHPUnit\Framework\TestCase;


class GetSettingsTest extends TestCase
{
    public function getExpected() {
        return (object) [
            "one" => (object) [
                "oneOne" => "1.1",
                "oneTwo" => "1.2",
                "oneThree" => (object) [
                    "oneThreeOne" => "1.3.1",
                    "oneThreeTwo" => "1.3.2",
                ]
            ],
            "two" => (object) [
                "twoOne" => "2.1",
                "twoTwo" => "2.2",
                "twoThree" => (object) [
                    "twoThreeOne" => "1.3.1",
                    "twoThreeTwo" => "1.3.2",
                ]
            ],
            "three" => (object) [
                "threeOne" => "3.1",
                "threeTwo" => "3.2"
            ]
        ];
    }

    public function getSettingsMock() {

        $stub = $this->getMockBuilder('FakeSettings')
            ->disableOriginalConstructor()
            ->getMock();

        $stub->one = (array) [
            "oneOne" => "1.1",
            "oneTwo" => "1.2",
            "oneThree" => (array) [
                "oneThreeOne" => "1.3.1",
                "oneThreeTwo" => "1.3.2",
            ]
        ];
        $stub->two = (array) [// provide an array, must return an object
            "twoOne" => "2.1",
            "twoTwo" => "2.2",
            "twoThree" => (object) [// provide an object, must return an object
                "twoThreeOne" => "1.3.1",
                "twoThreeTwo" => "1.3.2",
            ]
        ];
        $stub->three = (array) [
            "threeOne" => "3.1",
            "threeTwo" => "3.2"
        ];
        return $stub;
    }

    public function testGetSettings() {
        $expected = $this->getExpected();
        $getSettings = new GetSettings($this->getSettingsMock());
        $value = $getSettings->getSettings();
        $this->assertEquals((array)$expected, (array)$value);
    }

}
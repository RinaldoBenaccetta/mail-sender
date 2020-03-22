<?php

use MailSender\tools\Name;

class NameTest extends PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getBuildNameProvider
     *
     * @param $firstName
     * @param $name
     * @param $expected
     */
    public function testBuildName($firstName, $name, $expected)
    {
        $this->assertEquals($expected, Name::buildName($firstName, $name));
    }

    /**
     * @return array
     */
    public function getBuildNameProvider()
    {
        return [
            ['Sarah', 'Connor', 'Sarah Connor'],
            ['Sarah', null, 'Sarah'],
            [null, 'Connor', 'Connor'],
            [null, null, null],
        ];
    }
}
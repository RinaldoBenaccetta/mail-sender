<?php

use MailSender\tools\StringTool;


class StringToolTest extends PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideTestEndsWith
     *
     * @param $expected
     * @param $haystack
     * @param $needle
     */
    public function testEndsWith($expected, $haystack, $needle)
    {
        $this->assertEquals(
            $expected,
            StringTool::endsWith($haystack, $needle)
        );
    }

    public function provideTestEndsWith()
    {
        return [
            [true, 'Hello world!', 'world!'],
            [false, 'Hello world!', 'world'],
            [false, 'Hello world', 'Hello'],
            [false, 'Hello world!', 'Sarah Connor'],
        ];
    }

    /**
     * @dataProvider provideTestStartsWith
     *
     * @param $expected
     * @param $haystack
     * @param $needle
     */
    public function testStartsWith($expected, $haystack, $needle)
    {
        $this->assertEquals(
            $expected,
            StringTool::startsWith($haystack, $needle)
        );
    }

    public function provideTestStartsWith()
    {
        return [
            [true, 'Hello world!', 'Hello'],
            [false, 'Hello world!', 'ello'],
            [false, 'Hello world', 'world!'],
            [false, 'Hello world!', 'Sarah Connor'],
        ];
    }
}
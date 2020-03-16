<?php

require __DIR__ . "/../src/class/tools/StringTool.php";

use MailSender\tools\StringTool;


class StringToolTest extends PHPUnit\Framework\TestCase  {

  /**
   * @dataProvider provideTestEndsWith
   *
   * @param $expected
   * @param $haystack
   * @param $needle
   */
  public function testEndsWith($expected, $haystack, $needle) {
    $this->assertEquals($expected, StringTool::endsWith($haystack, $needle));
  }

  public function provideTestEndsWith() {
    return [
      [TRUE, 'Hello world!', 'world!'],
      [FALSE, 'Hello world!', 'world'],
      [FALSE, 'Hello world', 'Hello'],
      [FALSE, 'Hello world!', 'Sarah Connor']
    ];
  }

  /**
   * @dataProvider provideTestStartsWith
   *
   * @param $expected
   * @param $haystack
   * @param $needle
   */
  public function testStartsWith($expected, $haystack, $needle) {
    $this->assertEquals($expected, StringTool::startsWith($haystack, $needle));
  }

  public function provideTestStartsWith() {
    return [
      [TRUE, 'Hello world!', 'Hello'],
      [FALSE, 'Hello world!', 'ello'],
      [FALSE, 'Hello world', 'world!'],
      [FALSE, 'Hello world!', 'Sarah Connor']
    ];
  }
}
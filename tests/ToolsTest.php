<?php

//.\vendor\bin\require __DIR__ . "/../src/class/tools/Tools.php";

use MailSender\tools\Tools;

class ToolsTest extends PHPUnit\Framework\TestCase
{

  /**
   * @dataProvider getBuildNameProvider
   *
   * @param $firstName
   * @param $name
   * @param $expected
   */
  public function testBuildName($firstName, $name, $expected) {
    $this->assertEquals($expected, Tools::buildName($firstName, $name));
  }

  /**
   * @return array
   */
  public function getBuildNameProvider() {
    return [
      ['Sarah', 'Connor', 'Sarah Connor'],
      ['Sarah', NULL, 'Sarah'],
      [NULL, 'Connor', 'Connor'],
      [NULL, NULL, NULL],
    ];
  }
}
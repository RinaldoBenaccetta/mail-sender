<?php

require __DIR__ . "/../src/class/tools/Tools.php";

use MailSender\tools\Tools;

class ToolsTest extends PHPUnit\Framework\TestCase
{

  public function testBuildName() {
    $this->assertEquals('Sarah Connor', Tools::buildName('Sarah', 'Connor'));
    $this->assertEquals('Sarah', Tools::buildName('Sarah', null));
    $this->assertEquals('Connor', Tools::buildName(null, 'Connor'));
    $this->assertEquals(null, Tools::buildName(null, null));
  }
}
<?php

require __DIR__ . "/../src/class/mail/MailSettings.php";
require __DIR__ . "/../src/class/settings/Settings.php";
require __DIR__ . "/../src/class/settings/GetSettings.php";
require __DIR__ . "/../src/class/mail/DefaultContact.php";
require __DIR__ . "/../src/class/mail/MailOptions.php";
require __DIR__ . "/../src/class/tools/Tools.php";


use MailSender\mail\MailSettings;
//use MailSender\settings\GetSettings;
//use MailSender\settings\Settings;

class MailSettingsTest extends PHPUnit\Framework\TestCase {

//  public function invokeMethod(&$object, $methodName, array $parameters = array())
//  {
//    $reflection = new \ReflectionClass(get_class($object));
//    $method = $reflection->getMethod($methodName);
//    $method->setAccessible(true);
//    return $method->invokeArgs($object, $parameters);
//  }
//
//  public function testGetPost() {
//    $myClass = new MailSettings([]);
//    $object = $this->invokeMethod($myClass, 'getPost', []);
//    //$this->assertEquals('WI', $state);
//
//    //$mailSettings = new MailSettings();
//    $this->assertIsObject($object);
//  }

  public function testGetHost() {
    $mailSettings = new MailSettings([]);
    $this->assertEquals('test', $mailSettings->getHost());
  }

}
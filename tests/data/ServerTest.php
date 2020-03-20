<?php

use MailSender\data\Environment;
use MailSender\data\Server;


class ServerTest extends PHPUnit\Framework\TestCase {

  public function testGetServer() {
//    $test = $this->getMockBuilder(Environment::class)
//      ->setMethods(['getEnvironment'])
//      ->getMock();
//
//    $test->method('getEnvironment')->willReturn([
//      'HOST' => 'host',
//      'PORT' => 'port',
//      'ENCRYPTION' => 'encryption',
//      'SMTP_AUTHENTICATION' => 'false',
//      'MAIL_LOGIN' => 'sarah@connor.com',
//      'MAIL_PASSWORD' => 'myPassw0rd'
//    ]);


    $server = new Server();
    $settings = $server->getServerSettings();

    //var_dump($settings);

    $assertNotEmptyValues = $this->assertNotEmptyValues($settings);
    $assertHasKeyServer = $this->assertHasKeyServer($settings);



    $this->assertIsObject($settings);
    $this->assertTrue($assertNotEmptyValues);
    $this->assertTrue($assertHasKeyServer);
  }

  public function assertNotEmptyValues($settings) {
    foreach ($settings as $key => $value) {
      if (isset($value) && is_null($value)) {
        return FALSE;
      }
    }
    return TRUE;
  }

  public function assertHasKeyServer($settings) {
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
        return FALSE;
      }
    }
    return TRUE;
  }

}
<?php

use MailSender\mail\DefaultContact;
use MailSender\mail\MailOptions;
use MailSender\settings\GetSettings;


class MailOptionsTest extends PHPUnit\Framework\TestCase
{

  /**
   * @dataProvider getOptionsProvider
   *
   * @param $expected
   * @param $object
   */
  public function testOptions($expected, $object) {
    $mailOptions = new MailOptions($object);
    $this->assertEquals($expected, $mailOptions->getOptions());
    $this->assertIsArray($mailOptions->getOptions());

  }

  public function getOptionsProvider() {
    return [
      [(array) $this->defaultExpected(), (object) []],// provide empty object, get default options
      [(array) $this->provideAllData(), (object) $this->provideAllData()],// provide datas, get thes datas.
      [(array) $this->expectWithOnlySenderName(), (object) $this->provideOnlySenderName()],// provide datas with only sender name.
    ];
  }

  public function defaultExpected() {
    $settings = GetSettings::getSettings();
    return [
      'template' => $settings->defaultMailOptions->template,
      'senderMail' => $settings->defaultMailOptions->senderMail,
      'senderName' => $settings->defaultMailOptions->senderName,
      'recipientMail' => $settings->defaultMailOptions->recipientMail,
      'recipientName' => $settings->defaultMailOptions->recipientName,
      'subject' => DefaultContact::getSubject((object) [
        'senderName' => $settings->defaultMailOptions->senderName
      ]),
    ];
  }

  public function provideOnlySenderName() {
    return [
      'senderName' => 'Sarah Connor',
      ];
  }

  public function expectWithOnlySenderName() {
    $settings = GetSettings::getSettings();
    return [
      'template' => $settings->defaultMailOptions->template,
      'senderMail' => $settings->defaultMailOptions->senderMail,
      'senderName' => 'Sarah Connor',
      'recipientMail' => $settings->defaultMailOptions->recipientMail,
      'recipientName' => $settings->defaultMailOptions->recipientName,
      'subject' => DefaultContact::getSubject((object) [
        'senderName' => 'Sarah Connor'
      ]),
    ];
  }

  public function provideAllData() {
    return [
      'template' => 'beautiful-template',
      'senderMail' => 'T-800@skynet.com',
      'senderName' => 'T-800',
      'recipientMail' => 'sarah@connor.com',
      'recipientName' => 'Sarah Connor',
      'subject' => "I'll be back.",
    ];
  }

}
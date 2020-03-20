<?php

use MailSender\mail\DefaultContact;
use MailSender\mail\MailSettings;
use MailSender\settings\GetSettings;

class MailSettingsTest extends PHPUnit\Framework\TestCase {

  public function testGetHost() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->mailServer->host, $mailSettings->getHost());
  }

  public function testGetPort() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->mailServer->port, $mailSettings->getPort());
  }

  public function testGetEncryption() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->mailServer->encryption, $mailSettings->getEncryption());
  }

  public function testGetSmtpAuthentication() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->mailServer->smtpAuthentication, $mailSettings->getSmtpAuthentication());
  }

  public function testGetMailLogin() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->mailServer->mailLogin, $mailSettings->getMailLogin());
  }

  public function testGetMailPassword() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->mailServer->mailPassword, $mailSettings->getMailPassword());
  }

  public function testGetSenderMailWithMailProvided() {
    $senderMail = 't800@skynet.com';
    $mailSettings = new MailSettings([
      'senderMail'=>$senderMail
    ]);
    $this->assertEquals($senderMail, $mailSettings->getSenderMail());
  }

  public function testGetSenderMailWithoutMailProvided() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->defaultMailOptions->senderMail, $mailSettings->getSenderMail());
  }

  public function testGetSenderNameWithNameProvided() {
    $senderName = 'Sarah Connor';
    $mailSettings = new MailSettings([
      'senderName'=>$senderName
    ]);
    $this->assertEquals($senderName, $mailSettings->getSenderName());
  }

  public function testGetSenderNameWithoutNameProvided() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->defaultMailOptions->senderName, $mailSettings->getSenderName());
  }

  public function testGetReplyMailWithNameProvided() {
    $replyMail = 't800@skynet.com';
    $mailSettings = new MailSettings([
      'replyMail'=>$replyMail
    ]);
    $this->assertEquals($replyMail, $mailSettings->getReplyMail());
  }

  public function testGetReplyMailWithoutNameProvided() {
    $mailSettings = new MailSettings([]);
    $this->assertEquals(NULL, $mailSettings->getReplyMail());
  }

  public function testGetReplyNameWithNameProvided() {
    $replyName = 'Sarah Connor';
    $mailSettings = new MailSettings([
      'replyName'=>$replyName
    ]);
    $this->assertEquals($replyName, $mailSettings->getReplyName());
  }

  public function testGetReplyNameWithoutNameProvided() {
    $mailSettings = new MailSettings([]);
    $this->assertEquals(NULL, $mailSettings->getReplyName());
  }

  public function testGetRecipientMailWithMailProvided() {
    $recipientMail = 't800@skynet.com';
    $mailSettings = new MailSettings([
      'recipientMail'=>$recipientMail
    ]);
    $this->assertEquals($recipientMail, $mailSettings->getRecipientMail());
  }

  public function testGetRecipientMailWithoutMailProvided() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->defaultMailOptions->recipientMail, $mailSettings->getRecipientMail());
  }

  public function testGetRecipientNameWithNameProvided() {
    $recipientName = 'Sarah Connor';
    $mailSettings = new MailSettings([
      'recipientName'=>$recipientName
    ]);
    $this->assertEquals($recipientName, $mailSettings->getRecipientName());
  }

  public function testGetRecipientNameWithoutNameProvided() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([]);
    $this->assertEquals($settings->defaultMailOptions->recipientName, $mailSettings->getRecipientName());
  }

  public function testGetSubjectWithSubjectProvidedWithDefaultTemplate() {
    $settings = GetSettings::getSettings();
    $subject = "I'll be back";
    $expected = DefaultContact::getSubject((object) [
      'senderName' => $settings->defaultMailOptions->senderName
    ]);
    $mailSettings = new MailSettings([
      'subject' => $subject
    ]);
    $this->assertEquals($expected, $mailSettings->getSubject());
  }

  public function testGetSubjectWithoutSubjectProvidedWithDefaultTemplate() {
    $settings = GetSettings::getSettings();
    $expected = DefaultContact::getSubject((object) [
      'senderName' => $settings->defaultMailOptions->senderName
    ]);
    $mailSettings = new MailSettings([]);
    $this->assertEquals($expected, $mailSettings->getSubject());
  }

  public function testGetSubjectWithSubjectProvidedAndNotDefaultTemplate() {
    $subject = "I'll be back";
    $mailSettings = new MailSettings([
      'template' => 'test-template',
      'subject' => $subject
    ]);
    $this->assertEquals($subject, $mailSettings->getSubject());
  }

  public function testGetSubjectWithoutSubjectProvidedAndNotDefaultTemplate() {
    $settings = GetSettings::getSettings();
    $mailSettings = new MailSettings([
      'template' => 'test-template',
    ]);
    $this->assertEquals($settings->defaultMailOptions->subject, $mailSettings->getSubject());
  }

  public function testGetHtmlBody() {
    $message = 'Hello';
    $name = 'Sarah Connor';
    $expected = "Hello <strong>Sarah Connor</strong>";

    $mailSettings = new MailSettings([
      'message' => $message,
      'name' => $name,
      'template' => 'test-template',
    ]);

    $this->assertEquals($expected, $mailSettings->getHtmlBody());
  }

  public function testGetAltBodyWithAltBodyProvided() {
    $expected = "Hello Sarah Connor";

    $mailSettings = new MailSettings([
      'altBody' => $expected,
    ]);

    $this->assertEquals($expected, $mailSettings->getAltBody());
  }

  public function testGetAltBodyWithNoAltBodyProvided() {
    $mailSettings = new MailSettings([]);

    $this->assertEquals(NULL, $mailSettings->getAltBody());
  }




}
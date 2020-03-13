<?php

require __DIR__ . "/../src/class/mail/MailObject.php";

use MailSender\mail\MailObject;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class MailObjectTest extends PHPUnit\Framework\TestCase
{

  public function testHydrate() {
    $dataIn = [
      'host' => 'my.host.com',
      'port' => '8012',
      'encryptionMethod' => 'STARTTLS',
      'smtpAuthentication' => TRUE,
      'mailLogin' => 'myMail@exemple.com',
      'mailPassword' => '1234',
      'senderMail' => 't-800@exemple.com',
      'senderName' => 't-800',
      'replyMail' => 'noReply@exemple.com',
      'replyName' => 'nope',
      'recipientMail' => 'sarah@exemple.com',
      'recipientName' => 'Sarah Connor',
      'debug' => 'server',
      'subject' => 'Sarah Connor?',
      'htmlBody' => 'Hé bam',
      'altBody' => 'Ill be back',
    ];

    $dataOut = [
      'host' => 'my.host.com',
      'port' => '8012',
      'smtpAuthentication' => TRUE,
      'mailLogin' => 'myMail@exemple.com',
      'mailPassword' => '1234',
      'senderMail' => 't-800@exemple.com',
      'senderName' => 't-800',
      'replyMail' => 'noReply@exemple.com',
      'replyName' => 'nope',
      'recipientMail' => 'sarah@exemple.com',
      'recipientName' => 'Sarah Connor',
      'subject' => 'Sarah Connor?',
      'htmlBody' => 'Hé bam',
      'altBody' => 'Ill be back',
      'debug' => SMTP::DEBUG_SERVER,
      'encryptionMethod' => PHPMailer::ENCRYPTION_STARTTLS
    ];

    $mailObject = new MailObject($dataIn);

    $this->assertEquals($dataOut['host'], $mailObject->getHost());
    $this->assertEquals($dataOut['port'], $mailObject->getPort());
    $this->assertEquals($dataOut['smtpAuthentication'], $mailObject->getSmtpAuthentication());
    $this->assertEquals($dataOut['mailLogin'], $mailObject->getMailLogin());
    $this->assertEquals($dataOut['mailPassword'], $mailObject->getMailPassword());
    $this->assertEquals($dataOut['senderMail'], $mailObject->getSenderMail());
    $this->assertEquals($dataOut['senderName'], $mailObject->getSenderName());
    $this->assertEquals($dataOut['replyMail'], $mailObject->getReplyMail());
    $this->assertEquals($dataOut['replyName'], $mailObject->getReplyName());
    $this->assertEquals($dataOut['recipientMail'], $mailObject->getRecipientMail());
    $this->assertEquals($dataOut['recipientName'], $mailObject->getRecipientName());
    $this->assertEquals($dataOut['subject'], $mailObject->getSubject());
    $this->assertEquals($dataOut['htmlBody'], $mailObject->getHtmlBody());
    $this->assertEquals($dataOut['altBody'], $mailObject->getAltBody());
    $this->assertEquals($dataOut['debug'], $mailObject->getDebug());
    $this->assertEquals($dataOut['encryptionMethod'], $mailObject->getEncryptionMethod());
  }

  public function testHydrateWithoutReply() {
    $dataIn = [
      'senderMail' => 't-800@exemple.com',
      'senderName' => 't-800',
    ];

    $dataOut = [
      'senderMail' => 't-800@exemple.com',
      'senderName' => 't-800',
      'replyMail' => 't-800@exemple.com',
      'replyName' => 't-800',
    ];

    $mailObject = new MailObject($dataIn);

    $this->assertEquals($dataOut['senderMail'], $mailObject->getSenderMail());
    $this->assertEquals($dataOut['senderName'], $mailObject->getSenderName());
    $this->assertEquals($dataOut['replyMail'], $mailObject->getReplyMail());
    $this->assertEquals($dataOut['replyName'], $mailObject->getReplyName());
  }

  /**
   * Test using data provider.
   * https://phpunit.readthedocs.io/fr/latest/writing-tests-for-phpunit.html#fournisseur-de-donnees
   *
   * @dataProvider getDebugProvider
   *
   * @param $given
   * @param $expected
   */
  public function testGetDebug($given, $expected) {
    $mailObject = new MailObject(['debug' => $given]);
    $this->assertEquals($expected, $mailObject->getDebug());
  }

  public  function getDebugProvider() {
    return [
      ['off', SMTP::DEBUG_OFF],
      ['client', SMTP::DEBUG_CLIENT],
      ['server', SMTP::DEBUG_SERVER],
      ['', SMTP::DEBUG_OFF],
    ];
  }

  /**
   * Test using data provider.
   * https://phpunit.readthedocs.io/fr/latest/writing-tests-for-phpunit.html#fournisseur-de-donnees
   *
   * @dataProvider getEncryptionMethodProvider
   *
   * @param $given
   * @param $expected
   */
  public function testGetEncryptionMethod($given, $expected) {
    $mailObject = new MailObject(['encryptionMethod' => $given]);
    $this->assertEquals($expected, $mailObject->getEncryptionMethod());
  }

  public  function getEncryptionMethodProvider() {
    return [
      ['STARTTLS', PHPMailer::ENCRYPTION_STARTTLS],
      ['SMTPS', PHPMailer::ENCRYPTION_SMTPS],
    ];
  }

  public function testSetEncryptionMethod() {
    $this->expectException("Exception");

    $mailObject = new MailObject([]);
    $mailObject->setEncryptionMethod('bad encryption method');
  }

  public function testGetAltBodyWithoutSpecifiedAltBody() {
    $given = '<p style="color: green;">This is the HTML message body with text <b>in bold!</b></p>';
    $expected = 'This is the HTML message body with text in bold!';
    $mailObject = new MailObject(['htmlBody' => $given]);
    $this->assertEquals($expected, $mailObject->getAltBody());
  }

}
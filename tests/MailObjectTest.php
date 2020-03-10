<?php

require __DIR__ . "/../src/class/mail/MailObject.php";

use MailSender\mail\MailObject;


class MailObjectTest extends PHPUnit\Framework\TestCase
{

  public function testHydrate() {
    $dataIn = [
      'host' => 'my.host.com',
      'port' => '8012',
      'encryption' => 'STARTTLS',
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
      'htmlBody' => 'bam',
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
      'htmlBody' => 'bam',
      'altBody' => 'Ill be back',
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

}
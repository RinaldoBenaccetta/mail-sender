<?php

use MailSender\mail\MailObject;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class MailObjectTest extends PHPUnit\Framework\TestCase
{

    public function testHydrate()
    {
        $dataIn = [
            'host' => 'my.host.com',
            'port' => 8012,
            'encryptionMethod' => 'STARTTLS',
            'smtpAuthentication' => true,
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

        $expected = [
            'host' => 'my.host.com',
            'port' => 8012,
            'smtpAuthentication' => true,
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

        $this->assertEquals($expected['host'], $mailObject->getHost());
        $this->assertEquals($expected['port'], $mailObject->getPort());
        $this->assertEquals(
            $expected['smtpAuthentication'],
            $mailObject->getSmtpAuthentication()
        );
        $this->assertEquals(
            $expected['mailLogin'],
            $mailObject->getMailLogin()
        );
        $this->assertEquals(
            $expected['mailPassword'],
            $mailObject->getMailPassword()
        );
        $this->assertEquals(
            $expected['senderMail'],
            $mailObject->getSenderMail()
        );
        $this->assertEquals(
            $expected['senderName'],
            $mailObject->getSenderName()
        );
        $this->assertEquals(
            $expected['replyMail'],
            $mailObject->getReplyMail()
        );
        $this->assertEquals(
            $expected['replyName'],
            $mailObject->getReplyName()
        );
        $this->assertEquals(
            $expected['recipientMail'],
            $mailObject->getRecipientMail()
        );
        $this->assertEquals(
            $expected['recipientName'],
            $mailObject->getRecipientName()
        );
        $this->assertEquals($expected['subject'], $mailObject->getSubject());
        $this->assertEquals($expected['htmlBody'], $mailObject->getHtmlBody());
        $this->assertEquals($expected['altBody'], $mailObject->getAltBody());
        $this->assertEquals($expected['debug'], $mailObject->getDebug());
        $this->assertEquals(
            $expected['encryptionMethod'],
            $mailObject->getEncryptionMethod()
        );
    }

    public function testHydrateWithoutReply()
    {
        $dataIn = [
            'senderMail' => 't-800@exemple.com',
            'senderName' => 't-800',
        ];

        $expected = [
            'senderMail' => 't-800@exemple.com',
            'senderName' => 't-800',
            'replyMail' => 't-800@exemple.com',
            'replyName' => 't-800',
        ];

        $mailObject = new MailObject($dataIn);

        $this->assertEquals(
            $expected['senderMail'],
            $mailObject->getSenderMail()
        );
        $this->assertEquals(
            $expected['senderName'],
            $mailObject->getSenderName()
        );
        $this->assertEquals(
            $expected['replyMail'],
            $mailObject->getReplyMail()
        );
        $this->assertEquals(
            $expected['replyName'],
            $mailObject->getReplyName()
        );
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
    public function testGetDebug($given, $expected)
    {
        $mailObject = new MailObject(['debug' => $given]);
        $this->assertEquals($expected, $mailObject->getDebug());
    }

    public function getDebugProvider()
    {
        return [
            [(string)'off', SMTP::DEBUG_OFF],
            [(string)'client', SMTP::DEBUG_CLIENT],
            [(string)'server', SMTP::DEBUG_SERVER],
            [(string)'otherStuff', SMTP::DEBUG_OFF],
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
    public function testGetEncryptionMethod($given, $expected)
    {
        $mailObject = new MailObject(['encryptionMethod' => $given]);
        $this->assertEquals($expected, $mailObject->getEncryptionMethod());
    }

    public function getEncryptionMethodProvider()
    {
        return [
            ['STARTTLS', PHPMailer::ENCRYPTION_STARTTLS],
            ['SMTPS', PHPMailer::ENCRYPTION_SMTPS],
        ];
    }

    public function testSetEncryptionMethod()
    {
        $this->expectException("Exception");

        $mailObject = new MailObject([]);
        $mailObject->setEncryptionMethod('bad encryption method');
    }

    public function testGetAltBodyWithoutSpecifiedAltBody()
    {
        $given = '<p style="color: green;">This is the HTML message body with text <b>in bold!</b></p>';
        $expected = 'This is the HTML message body with text in bold!';
        $mailObject = new MailObject(['htmlBody' => $given]);
        $this->assertEquals($expected, $mailObject->getAltBody());
    }

}
<?php

use MailSender\mail\DefaultContact;
use MailSender\mail\MailSettings;
use MailSender\settings\GetSettings;

class MailSettingsTest extends PHPUnit\Framework\TestCase
{

    public function getServerSettings() {
        return (object) [
            "host" => "smtp.gmail.com",
            "port" => "587",
            "encryption" => "STARTTLS",
            "smtpAuthentication" => true,
            "mailLogin" => "sarah@connor.com",
            "mailPassword" => "myPassword",
        ];
    }

    public function getSettings() {
        return (object) GetSettings::getSettings();
    }

    public function getMailSettings() {
        $settings = $this->getSettings();
        $serverSettings = $this->getServerSettings();
        return new MailSettings($settings, $serverSettings);
    }



    public function testGetHost()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServerSettings()->host,
            $mailSettings->getHost()
        );
    }

    public function testGetPort()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServerSettings()->port,
            $mailSettings->getPort()
        );
    }

    public function testGetEncryption()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServerSettings()->encryption,
            $mailSettings->getEncryption()
        );
    }

    public function testGetSmtpAuthentication()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServerSettings()->smtpAuthentication,
            $mailSettings->getSmtpAuthentication()
        );
    }

    public function testGetMailLogin()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServerSettings()->mailLogin,
            $mailSettings->getMailLogin()
        );
    }

    public function testGetMailPassword()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServerSettings()->mailPassword,
            $mailSettings->getMailPassword()
        );
    }

    public function testGetSenderMailWithMailProvided()
    {
        $senderMail = 't800@skynet.com';
        $mailSettings = new MailSettings(
            (object)[
                'senderMail' => $senderMail
            ], $this->getServerSettings()
        );
        $this->assertEquals($senderMail, $mailSettings->getSenderMail());
    }

    public function testGetSenderMailWithoutMailProvided()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->senderMail,
            $mailSettings->getSenderMail()
        );
    }

    public function testGetSenderNameWithNameProvided()
    {
        $senderName = 'Sarah Connor';
        $mailSettings = new MailSettings(
            (object) [
                'senderName' => $senderName
            ], $this->getServerSettings()
        );
        $this->assertEquals($senderName, $mailSettings->getSenderName());
    }

    public function testGetSenderNameWithoutNameProvided()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->senderName,
            $mailSettings->getSenderName()
        );
    }

    public function testGetReplyMailWithNameProvided()
    {
        $replyMail = 't800@skynet.com';
        $mailSettings = new MailSettings(
            (object) [
                'replyMail' => $replyMail
            ], $this->getServerSettings()
        );
        $this->assertEquals($replyMail, $mailSettings->getReplyMail());
    }

    public function testGetReplyMailWithoutNameProvided()
    {
        $mailSettings = new MailSettings([], $this->getServerSettings());
        $this->assertEquals(null, $mailSettings->getReplyMail());
    }

    public function testGetReplyNameWithNameProvided()
    {
        $replyName = 'Sarah Connor';
        $mailSettings = new MailSettings(
            (object) [
                'replyName' => $replyName
            ], $this->getServerSettings()
        );
        $this->assertEquals($replyName, $mailSettings->getReplyName());
    }

    public function testGetReplyNameWithoutNameProvided()
    {
        $mailSettings = new MailSettings([], $this->getServerSettings());
        $this->assertEquals(null, $mailSettings->getReplyName());
    }

    public function testGetRecipientMailWithMailProvided()
    {
        $recipientMail = 't800@skynet.com';
        $mailSettings = new MailSettings(
            (object) [
                'recipientMail' => $recipientMail
            ], $this->getServerSettings()
        );
        $this->assertEquals($recipientMail, $mailSettings->getRecipientMail());
    }

    public function testGetRecipientMailWithoutMailProvided()
    {
        $mailSettings = new MailSettings([], $this->getServerSettings());
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->recipientMail,
            $mailSettings->getRecipientMail()
        );
    }

    public function testGetRecipientNameWithNameProvided()
    {
        $recipientName = 'Sarah Connor';
        $mailSettings = new MailSettings(
            (object) [
                'recipientName' => $recipientName
            ], $this->getServerSettings()
        );
        $this->assertEquals($recipientName, $mailSettings->getRecipientName());
    }

    public function testGetRecipientNameWithoutNameProvided()
    {
        //$settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([], $this->getServerSettings());
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->recipientName,
            $mailSettings->getRecipientName()
        );
    }

    public function testGetSubjectWithSubjectProvidedWithDefaultTemplate()
    {
        $subject = "I'll be back";
        $expected = DefaultContact::getSubject(
            (object)[
                'senderName' => $this->getSettings()->defaultMailOptions->senderName
            ]
        );
        $mailSettings = new MailSettings(
            (object) [
                'subject' => $subject
            ], $this->getServerSettings()
        );
        $this->assertEquals($expected, $mailSettings->getSubject());
    }

    public function testGetSubjectWithoutSubjectProvidedWithDefaultTemplate()
    {
        $expected = DefaultContact::getSubject(
            (object)[
                'senderName' => $this->getSettings()->defaultMailOptions->senderName
            ]
        );
        $mailSettings = new MailSettings([], $this->getServerSettings());
        $this->assertEquals($expected, $mailSettings->getSubject());
    }

    public function testGetSubjectWithSubjectProvidedAndNotDefaultTemplate()
    {
        $subject = "I'll be back";
        $mailSettings = new MailSettings(
            [
                'template' => 'test-template',
                'subject' => $subject
            ], $this->getServerSettings()
        );
        $this->assertEquals($subject, $mailSettings->getSubject());
    }

    public function testGetSubjectWithoutSubjectProvidedAndNotDefaultTemplate()
    {
        $mailSettings = new MailSettings(
            [
                'template' => 'test-template',
            ], $this->getServerSettings()
        );
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->subject,
            $mailSettings->getSubject()
        );
    }

    public function testGetHtmlBody()
    {
        $message = 'Hello';
        $name = 'Sarah Connor';
        $expected = "Hello <strong>Sarah Connor</strong>";

        $mailSettings = new MailSettings(
            [
                'message' => $message,
                'name' => $name,
                'template' => 'test-template',
            ], $this->getServerSettings()
        );

        $this->assertEquals($expected, $mailSettings->getHtmlBody());
    }

    public function testGetAltBodyWithAltBodyProvided()
    {
        $expected = "Hello Sarah Connor";

        $mailSettings = new MailSettings(
            [
                'altBody' => $expected,
            ], $this->getServerSettings()
        );

        $this->assertEquals($expected, $mailSettings->getAltBody());
    }

    public function testGetAltBodyWithNoAltBodyProvided()
    {
        $mailSettings = new MailSettings([], $this->getServerSettings());

        $this->assertEquals(null, $mailSettings->getAltBody());
    }


}
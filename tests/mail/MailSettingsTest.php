<?php

use MailSender\mail\DefaultContact;
use MailSender\mail\MailSettings;
use MailSender\settings\GetSettings;

class MailSettingsTest extends PHPUnit\Framework\TestCase
{


    /**
     * Add test server values.
     *
     * @return object
     */
    public function getJoinedSettings()
    {
//        $testServer = [
//            "mailServer" => (object)[
//                "host" => "smtp.gmail.com",
//                "port" => "587",
//                "encryption" => "STARTTLS",
//                "smtpAuthentication" => true,
//                "mailLogin" => "sarah@connor.com",
//                "mailPassword" => "myPassword",
//            ]
//        ];
//        $settings = (array)GetSettings::getSettings();

        return (object)array_merge($this->getSettings(), $this->getServerSettings());
        //return (object)array_merge($settings, $testServer);
    }

    public function getServerSettings() {
        return [
            "mailServer" => (object) [
                "host" => "smtp.gmail.com",
                "port" => "587",
                "encryption" => "STARTTLS",
                "smtpAuthentication" => true,
                "mailLogin" => "sarah@connor.com",
                "mailPassword" => "myPassword",
            ]
        ];
    }

    public function getSettings() {
        return (array) GetSettings::getSettings();
    }



    public function testGetHost()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->mailServer->host,
            $mailSettings->getHost()
        );
    }

    public function testGetPort()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->mailServer->port,
            $mailSettings->getPort()
        );
    }

    public function testGetEncryption()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->mailServer->encryption,
            $mailSettings->getEncryption()
        );
    }

    public function testGetSmtpAuthentication()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->mailServer->smtpAuthentication,
            $mailSettings->getSmtpAuthentication()
        );
    }

    public function testGetMailLogin()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings((object) $this->getServerSettings());
        dump($this->getServerSettings());
        $this->assertEquals(
            $settings->mailServer->mailLogin,
            $mailSettings->getMailLogin()
        );
    }

    public function testGetMailPassword()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->mailServer->mailPassword,
            $mailSettings->getMailPassword()
        );
    }

    public function testGetSenderMailWithMailProvided()
    {
        $senderMail = 't800@skynet.com';
        $mailSettings = new MailSettings(
            (object)[
                'senderMail' => $senderMail
            ]
        );
        $this->assertEquals($senderMail, $mailSettings->getSenderMail());
    }

    public function testGetSenderMailWithoutMailProvided()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->defaultMailOptions->senderMail,
            $mailSettings->getSenderMail()
        );
    }

    public function testGetSenderNameWithNameProvided()
    {
        $senderName = 'Sarah Connor';
        $mailSettings = new MailSettings(
            [
                'senderName' => $senderName
            ]
        );
        $this->assertEquals($senderName, $mailSettings->getSenderName());
    }

    public function testGetSenderNameWithoutNameProvided()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->defaultMailOptions->senderName,
            $mailSettings->getSenderName()
        );
    }

    public function testGetReplyMailWithNameProvided()
    {
        $replyMail = 't800@skynet.com';
        $mailSettings = new MailSettings(
            [
                'replyMail' => $replyMail
            ]
        );
        $this->assertEquals($replyMail, $mailSettings->getReplyMail());
    }

    public function testGetReplyMailWithoutNameProvided()
    {
        $mailSettings = new MailSettings([]);
        $this->assertEquals(null, $mailSettings->getReplyMail());
    }

    public function testGetReplyNameWithNameProvided()
    {
        $replyName = 'Sarah Connor';
        $mailSettings = new MailSettings(
            [
                'replyName' => $replyName
            ]
        );
        $this->assertEquals($replyName, $mailSettings->getReplyName());
    }

    public function testGetReplyNameWithoutNameProvided()
    {
        $mailSettings = new MailSettings([]);
        $this->assertEquals(null, $mailSettings->getReplyName());
    }

    public function testGetRecipientMailWithMailProvided()
    {
        $recipientMail = 't800@skynet.com';
        $mailSettings = new MailSettings(
            [
                'recipientMail' => $recipientMail
            ]
        );
        $this->assertEquals($recipientMail, $mailSettings->getRecipientMail());
    }

    public function testGetRecipientMailWithoutMailProvided()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->defaultMailOptions->recipientMail,
            $mailSettings->getRecipientMail()
        );
    }

    public function testGetRecipientNameWithNameProvided()
    {
        $recipientName = 'Sarah Connor';
        $mailSettings = new MailSettings(
            [
                'recipientName' => $recipientName
            ]
        );
        $this->assertEquals($recipientName, $mailSettings->getRecipientName());
    }

    public function testGetRecipientNameWithoutNameProvided()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings([]);
        $this->assertEquals(
            $settings->defaultMailOptions->recipientName,
            $mailSettings->getRecipientName()
        );
    }

    public function testGetSubjectWithSubjectProvidedWithDefaultTemplate()
    {
        $settings = $this->getJoinedSettings();
        $subject = "I'll be back";
        $expected = DefaultContact::getSubject(
            (object)[
                'senderName' => $settings->defaultMailOptions->senderName
            ]
        );
        $mailSettings = new MailSettings(
            [
                'subject' => $subject
            ]
        );
        $this->assertEquals($expected, $mailSettings->getSubject());
    }

    public function testGetSubjectWithoutSubjectProvidedWithDefaultTemplate()
    {
        $settings = $this->getJoinedSettings();
        $expected = DefaultContact::getSubject(
            (object)[
                'senderName' => $settings->defaultMailOptions->senderName
            ]
        );
        $mailSettings = new MailSettings([]);
        $this->assertEquals($expected, $mailSettings->getSubject());
    }

    public function testGetSubjectWithSubjectProvidedAndNotDefaultTemplate()
    {
        $subject = "I'll be back";
        $mailSettings = new MailSettings(
            [
                'template' => 'test-template',
                'subject' => $subject
            ]
        );
        $this->assertEquals($subject, $mailSettings->getSubject());
    }

    public function testGetSubjectWithoutSubjectProvidedAndNotDefaultTemplate()
    {
        $settings = $this->getJoinedSettings();
        $mailSettings = new MailSettings(
            [
                'template' => 'test-template',
            ]
        );
        $this->assertEquals(
            $settings->defaultMailOptions->subject,
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
            ]
        );

        $this->assertEquals($expected, $mailSettings->getHtmlBody());
    }

    public function testGetAltBodyWithAltBodyProvided()
    {
        $expected = "Hello Sarah Connor";

        $mailSettings = new MailSettings(
            [
                'altBody' => $expected,
            ]
        );

        $this->assertEquals($expected, $mailSettings->getAltBody());
    }

    public function testGetAltBodyWithNoAltBodyProvided()
    {
        $mailSettings = new MailSettings([]);

        $this->assertEquals(null, $mailSettings->getAltBody());
    }


}
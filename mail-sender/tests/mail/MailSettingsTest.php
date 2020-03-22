<?php

use MailSender\data\Server;
use MailSender\mail\DefaultContact;
use MailSender\mail\MailOptions;
use MailSender\mail\MailSettings;
use PHPUnit\Framework\TestCase;
use MailSender\settings\GetSettings;
use MailSender\data\Post;

class MailSettingsTest extends TestCase
{

    public function testGetHost()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServer()->host,
            $mailSettings->getHost()
        );
    }

    public function getMailSettings()
    {
        return $this->getCustomMailSettings($this->getPost());
    }

    public function getCustomMailSettings(
        $array = [
            'provideSomething' => 'something'
        ]
    ) {
        $post = $this->createMock(Post::class);

        $post->method('getPost')
            ->willReturn((object)$array);

        $server = $this->createMock(Server::class);

        $server->method('getServerSettings')
            ->willReturn($this->getServer());

        $mailOptions = new MailOptions($array, $this->getSettings());

        return new MailSettings($post, $server, $mailOptions, $this->getSettings());
    }

    public function getServer()
    {
        return (object)[
            "host" => "smtp.gmail.com",
            "port" => "587",
            "encryption" => "STARTTLS",
            "smtpAuthentication" => true,
            "mailLogin" => "sarah@connor.com",
            "mailPassword" => "myPassword",
        ];
    }

    public function getSettings()
    {
        return (object)[
            'global' => (object)[
                'environment' => 'dev',
                'rootParent' => '1',
            ],
            'defaultMailOptions' => (object)[
                'template' => 'test-template',
                'senderMail' => 't800@skynet.com',
                'senderName' => 'T-800',
                'recipientMail' => 'sarah@connor.com',
                'recipientName' => 'Sarah Connor',
                'subject' => 'I ll be back!',
            ],
            'validation' => (object)[
                'isMail' => [
                    'senderMail',
                    'replyMail',
                    'recipientMail'
                ],
                'DNSMailValidation' => true,
                'SpoofMailValidation' => true,
            ],
            'defaultContactTemplate' => (object)[
                'subjectPrefix' => "suffix",
                'subjectSuffix' => "preffix",
            ]
        ];
    }

    public function getPost()
    {
        return (array)[
            'senderMail' => 't1000@skynet.com',
            'senderName' => 'T-1000',
            'replyMail' => 'Arnold@skynet.com',
            'replyName' => 'Arnold',
            'recipientMail' => 'sarah@connor.com',
            'recipientName' => 'Sarah Connor',
            'subject' => 'Sarah Connor?',
        ];
    }

    public function testGetPort()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServer()->port,
            $mailSettings->getPort()
        );
    }

    public function testGetEncryption()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServer()->encryption,
            $mailSettings->getEncryption()
        );
    }

    public function testGetSmtpAuthentication()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServer()->smtpAuthentication,
            $mailSettings->getSmtpAuthentication()
        );
    }

    public function testGetMailLogin()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServer()->mailLogin,
            $mailSettings->getMailLogin()
        );
    }

    public function testGetMailPassword()
    {
        $mailSettings = $this->getMailSettings();
        $this->assertEquals(
            $this->getServer()->mailPassword,
            $mailSettings->getMailPassword()
        );
    }

    public function testGetSenderMailWithMailProvided()
    {
        $senderMail = 't800@skynet.com';
        $mailSettings = $this->getCustomMailSettings(
            [
                'senderMail' =>
                    $senderMail
            ]
        );
        $this->assertEquals($senderMail, $mailSettings->getSenderMail());
    }

    public function testGetSenderMailWithoutMailProvided()
    {
        $mailSettings = $this->getCustomMailSettings();
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->senderMail,
            $mailSettings->getSenderMail()
        );
    }

    public function testGetSenderNameWithNameProvided()
    {
        $senderName = 'Sarah Connor';
        $mailSettings = $this->getCustomMailSettings(
            ['senderName' => $senderName]
        );
        $this->assertEquals($senderName, $mailSettings->getSenderName());
    }

    public function testGetSenderNameWithoutNameProvided()
    {
        $mailSettings = $this->getCustomMailSettings();
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->senderName,
            $mailSettings->getSenderName()
        );
    }

    public function testGetReplyMailWithNameProvided()
    {
        $replyMail = 't800@skynet.com';
        $mailSettings = $this->getCustomMailSettings(
            ['replyMail' => $replyMail]
        );
        $this->assertEquals($replyMail, $mailSettings->getReplyMail());
    }

    public function testGetReplyMailWithoutNameProvided()
    {
        $mailSettings = $this->getCustomMailSettings();
        $this->assertEquals(null, $mailSettings->getReplyMail());
    }

    public function testGetReplyNameWithNameProvided()
    {
        $replyName = 'Sarah Connor';
        $mailSettings = $this->getCustomMailSettings(
            ['replyName' => $replyName]
        );
        $this->assertEquals($replyName, $mailSettings->getReplyName());
    }

    public function testGetReplyNameWithoutNameProvided()
    {
        $mailSettings = $this->getCustomMailSettings();
        $this->assertEquals(null, $mailSettings->getReplyName());
    }

    public function testGetRecipientMailWithMailProvided()
    {
        $recipientMail = 't800@skynet.com';
        $mailSettings = $this->getCustomMailSettings(
            ['recipientMail' => $recipientMail]
        );
        $this->assertEquals($recipientMail, $mailSettings->getRecipientMail());
    }

    public function testGetRecipientMailWithoutMailProvided()
    {
        $mailSettings = $this->getCustomMailSettings();
        $this->assertEquals(
            $this->getSettings()->defaultMailOptions->recipientMail,
            $mailSettings->getRecipientMail()
        );
    }

    public function testGetRecipientNameWithNameProvided()
    {
        $recipientName = 'Sarah Connor';
        $mailSettings = $this->getCustomMailSettings(
            ['recipientName' => $recipientName]
        );
        $this->assertEquals($recipientName, $mailSettings->getRecipientName());
    }

    public function testGetRecipientNameWithoutNameProvided()
    {
        $mailSettings = $this->getCustomMailSettings();
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
                'senderName' => $this->getSettings(
                )->defaultMailOptions->senderName
            ],
            $this->getSettings()
        );
        $mailSettings = $this->getCustomMailSettings(
            [
                'template' => 'contact-default',
                'subject' => $subject
            ]
        );
        $this->assertEquals($expected, $mailSettings->getSubject());
    }

    public function testGetSubjectWithoutSubjectProvidedWithDefaultTemplate()
    {
        $expected = DefaultContact::getSubject(
            (object)[
                'senderName' => $this->getSettings(
                )->defaultMailOptions->senderName
            ],
            $this->getSettings()
        );
        $mailSettings = $this->getCustomMailSettings(
            [
                'template' => 'contact-default',
            ]
        );
        $this->assertEquals($expected, $mailSettings->getSubject());
    }

    public function testGetSubjectWithSubjectProvidedAndNoDefaultTemplate()
    {
        $subject = "I'll be back";
        $mailSettings = $this->getCustomMailSettings(
            [
                'template' => 'test-template',
                'subject' => $subject
            ]
        );
        $this->assertEquals($subject, $mailSettings->getSubject());
    }

    public function testGetSubjectWithoutSubjectProvidedAndNoDefaultTemplate()
    {
        $mailSettings = $this->getCustomMailSettings(
            ['template' => 'test-template']
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
        $mailSettings = $this->getCustomMailSettings(
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
        $mailSettings = $this->getCustomMailSettings(['altBody' => $expected]);
        $this->assertEquals($expected, $mailSettings->getAltBody());
    }

    public function testGetAltBodyWithNoAltBodyProvided()
    {
        $mailSettings = $this->getCustomMailSettings();
        $this->assertEquals(null, $mailSettings->getAltBody());
    }


}
<?php

use MailSender\data\Post;
use MailSender\mail\MailOptions;


class MailOptionsTest extends PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getOptionsProvider
     *
     * @param $expected
     * @param $object
     */
    public function testOptions($expected, $object)
    {
        $mailOptions = $this->getMailOptions($object);
        $this->assertEquals($expected, $mailOptions->getOptions());
        $this->assertIsArray($mailOptions->getOptions());
    }

    public function getMailOptions($object)
    {
        $post = $this->createMock(Post::class);

        $post->method('getPost')
            ->willReturn((object)$object);

        return new MailOptions($post, $this->getSettings());
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

    public function getOptionsProvider()
    {
        return [
            [(array)$this->defaultExpected(), (array)[]],
            // provide empty object, get default options
            [(array)$this->provideAllData(), (array)$this->provideAllData()],
            // provide datas, get theses datas.
            [
                (array)$this->expectWithOnlySenderName(),
                (array)
                $this->provideOnlySenderName()
            ],
            // provide datas with only sender name.
        ];
    }

    public function defaultExpected()
    {
        $settings = $this->getSettings();
        return [
            'template' => $settings->defaultMailOptions->template,
            'senderMail' => $settings->defaultMailOptions->senderMail,
            'senderName' => $settings->defaultMailOptions->senderName,
            'recipientMail' => $settings->defaultMailOptions->recipientMail,
            'recipientName' => $settings->defaultMailOptions->recipientName,
            'subject' => $settings->defaultMailOptions->subject,
        ];
    }

    public function provideAllData()
    {
        return [
            'template' => 'beautiful-template',
            'senderMail' => 'T-800@skynet.com',
            'senderName' => 'T-800',
            'recipientMail' => 'sarah@connor.com',
            'recipientName' => 'Sarah Connor',
            'subject' => "I'll be back.",
        ];
    }

    public function expectWithOnlySenderName()
    {
        $settings = $this->getSettings();
        return [
            'template' => $settings->defaultMailOptions->template,
            'senderMail' => $settings->defaultMailOptions->senderMail,
            'senderName' => 'Sarah Connor',
            'recipientMail' => $settings->defaultMailOptions->recipientMail,
            'recipientName' => $settings->defaultMailOptions->recipientName,
            'subject' => $settings->defaultMailOptions->subject,
        ];
    }

    public function provideOnlySenderName()
    {
        return [
            'senderName' => 'Sarah Connor',
        ];
    }

}
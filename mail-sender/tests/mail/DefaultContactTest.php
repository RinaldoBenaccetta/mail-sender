<?php

use MailSender\mail\DefaultContact;

class DefaultContactTest extends PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getGetNameProvider
     *
     * @param $firstName
     * @param $name
     * @param $expected
     */
    public function testGetName($firstName, $name, $expected)
    {
        $this->assertEquals(
            $expected,
            DefaultContact::getName(
                (object)[
                    'senderFirstName' => $firstName,
                    'senderName' => $name,
                ]
            )
        );
    }

    /**
     * @return array
     */
    public function getGetNameProvider()
    {
        return [
            ['Sarah', 'Connor', 'Sarah Connor'],
            ['Sarah', null, 'Sarah'],
            [null, 'Connor', 'Connor'],
            [null, null, null],
        ];
    }

    public function testGetSubject()
    {
        $this->assertEquals(
            "suffixSarah Connorpreffix",
            DefaultContact::getSubject(
                (object)[
                    'senderFirstName' => 'Sarah',
                    'senderName' => 'Connor'
                ],
                $this->getSettings()
            )
        );
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
}
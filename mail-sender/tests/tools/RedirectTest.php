<?php


namespace tests\MailSender\tools;

use MailSender\tools\Redirect;
use PHPUnit\Framework\TestCase;

class RedirectTest extends TestCase
{
    public function getSettings()
    {
        return (object)[
            'global' => (object)[
                'environment' => 'dev',
                'rootParent' => '1',
                'htmlRootParent' => '1'
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

    public function getLink() {
        return 'redirect.html';
    }

    /**
     * from https://vfac.fr/blog/phpunit-test-a-method-with-redirection
     *
     * @runInSeparateProcess
     */
    public function testRedirect() {
        new Redirect($this->getSettings(), $this->getLink());
        $this->assertContains(
            "Location: ../{$this->getLink()}", xdebug_get_headers()
        );
    }

}
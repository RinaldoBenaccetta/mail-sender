<?php

use MailSender\render\Render;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class RenderTest
 */
class RenderTest extends PHPUnit\Framework\TestCase
{
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

    /**
     * @dataProvider provideTestRender
     *
     * @param $template
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function testRender($template)
    {
        $message = 'Hello';
        $name = 'Sarah Connor';
        $expected = "Hello <strong>Sarah Connor</strong>";

        $this->assertEquals(
            $expected,
            Render::render(
                $template,
                [
                    'message' => $message,
                    'name' => $name
                ],
                $this->getSettings(),
                )
        );
    }

    public function provideTestRender()
    {
        return [
            ['test-template'], // test without .twig extension
            ['test-template.twig'], // test with twig extension
        ];
    }

}
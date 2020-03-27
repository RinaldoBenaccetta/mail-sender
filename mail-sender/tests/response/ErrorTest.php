<?php

namespace response;

use MailSender\response\Error;
use PHPUnit\Framework\TestCase;

class ErrorTest extends TestCase
{

    /**
     * @dataProvider getGetDataProvider
     *
     * @param $post
     * @param $expected
     */
    public function testErrorWithFilledPostClient($post, $expected)
    {
        $_POST['client'] = $post;
        new Error($this->getSettings(), $this->getErrorPage());
        $this->expectOutputString($expected);
    }

    /**
     * @runInSeparateProcess
     */
    public function testErrorWithoutFilledPostClient()
    {
        $_POST = [];
        new Error($this->getSettings(), $this->getErrorPage());

        $this->assertContains(
            "Location: ../{$this->getErrorPage()}",
            xdebug_get_headers()
        );
    }

    public function getErrorPage()
    {
        return 't-800.com';
    }

    public function getSettings()
    {
        return (object)[
            'redirect' => (object)[
                'htmlRootParent' => '1',
            ],
            'response' => (object)[
                'error' => 'bad news'
            ]
        ];
    }

    /**
     * @return array
     */
    public function getGetDataProvider()
    {
        return [
            ['js', $this->getSettings()->response->error],
            ['something', $this->getSettings()->response->error],
        ];
    }
}

<?php

namespace response;

use MailSender\response\ReturnError;
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
        // expect return a string with the error and code.
        $_POST['client'] = $post;
        new ReturnError($this->getSettings(), $this->getErrorPage());
        $this->expectOutputString($expected);
    }

    /**
     * @runInSeparateProcess
     */
    public function testErrorWithoutFilledPostClient()
        // expect redirect to error page.
    {
        $_POST = [];
        new ReturnError($this->getSettings(), $this->getErrorPage());

        $this->assertContains(
            "Location: ../{$this->getErrorPage()}",
            xdebug_get_headers()
        );
    }

    public function testErrorWithoutFilledPostClientAndEmptyErrorPage()
    {
        // expect return a string with the error and code.
        $_POST = [];
        new ReturnError($this->getSettings(), NULL);
        $this->expectOutputString($this->getSettings()->response->error . ":9000");
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
        // add code 9000 at the end.
        return [
            ['js', $this->getSettings()->response->error . ":9000"],
            ['something', $this->getSettings()->response->error . ":9000"],
        ];
    }
}

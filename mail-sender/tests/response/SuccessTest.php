<?php

namespace response;

use MailSender\response\Success;
use PHPUnit\Framework\TestCase;

class SuccessTest extends TestCase
{

    /**
     * @dataProvider getGetDataProvider
     *
     * @param $post
     * @param $expected
     */
    public function testSuccessWithFilledPostClient($post, $expected)
    {
        $_POST['client'] = $post;
        new Success($this->getSettings());
        $this->expectOutputString($expected);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSuccessWithoutFilledPostClient()
    {
        $_POST = [];
        new Success($this->getSettings());

        $this->assertContains(
            "Location: ../{$this->getSettings()->redirect->defaultMailOkPage}",
            xdebug_get_headers()
        );
    }

    public function getSettings()
    {
        return (object)[
            'redirect' => (object)[
                'defaultMailOkPage' => 'success',
                'htmlRootParent' => '1',
            ],
            'response' => (object)[
                'success' => 'great'
            ]
        ];
    }

    /**
     * @return array
     */
    public function getGetDataProvider()
    {
        return [
            ['js', $this->getSettings()->response->success],
            ['something', $this->getSettings()->response->success],
        ];
    }
}

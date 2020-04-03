<?php

namespace response;

use MailSender\response\ReturnSuccess;
use PHPUnit\Framework\TestCase;

class ReturnSuccessTest extends TestCase
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
        new ReturnSuccess($this->getSettings());
        $this->expectOutputString($expected);
    }

    public function testSuccessWithoutFilledPostClient()
    {
        $_POST = [];
        new ReturnSuccess($this->getSettings());
        $this->expectOutputString($this->getSettings()->response->success);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSuccessWithRedirectTrue()
    {
        $_POST = [
            'redirect' => true,
        ];
        new ReturnSuccess($this->getSettings());
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
                'success' => 'great',
            ],
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

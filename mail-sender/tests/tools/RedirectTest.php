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
                'htmlRootParent' => '1'
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
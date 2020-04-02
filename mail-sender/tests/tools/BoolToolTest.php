<?php

namespace tools;

use MailSender\tools\BoolTool;
use PHPUnit\Framework\TestCase;

class BoolToolTest extends TestCase
{
    /**
     * @dataProvider getToBoolProvider
     *
     * @param $provided
     * @param $expected
     */
    public function testToBool($provided, $expected) {
        $this->assertEquals($expected, BoolTool::toBool($provided));
    }

    /**
     * @return array
     */
    public function getToBoolProvider() {
        return [
            [true, true],
            ['true', true],
            ['TRUE', true],
            [1, true],
            [false, false],
            [null, false],
            ['', false],
            ['false', false],
            ['FALSE', false],
            [0, false]
        ];
    }

}

<?php


namespace tests\MailSender\data;

use Exception;
use PHPUnit\Framework\TestCase;
use MailSender\data\Post;


class PostTest extends TestCase
{

    /**
     *
     * @throws Exception
     */
    public function testSanitize()
    {
        $data = new Post($this->getGiven());
        $this->assertEquals($this->getExpected(), $data->getPost());
    }

    public function getGiven()
    {
        return (array)[
            "senderName" => "Connor",
            "senderFirstName" => "Sarah",
            "senderPhone" => 12563,
            "senderMail" => "Sarah@Connor.com",
            "message" => "Hello <bold>world!</bold>",
            "dangerous" => "<script>alert('I ll be back!');</script>",
            "object" => (object)[
                "firstItem" => "anItem",
                "withAnArray" => [
                    "firstItem" => "OtherItem",
                    "andAnotherArray" => [
                        "andAlsoAnotherArray" => [
                            "anOtherItem" => 12345,
                            "andAnother" => "andAnotherItem",
                        ]
                    ]
                ]
            ],
            "boolean" => [
                "true" => true,
                "false" => false,
            ],
            "integer" => [
                "decimal" => 1234,
                "octal" => 0123,
                "hexadecimal" => 0x1A,
                "binary" => 0b11111111,
                "anOtherDecimal" => 1_234_567, // from PHP 7.4.0
            ],
            "float" => [
                "first" => 1.234,
                "second" => 1.2e3,
                "third" => 7E-10,
                "fourth" => 1_234.567, // from PHP 7.4.0
            ],
            "null" => null,
            "test" => "<?php echo 'test'",
            "escape" => "O'Reilly?\/",
            "otherEscape" => 'Hello "You" !'
        ];
    }

    public function getExpected()
    {
        return (array)[
            "senderName" => "Connor",
            "senderFirstName" => "Sarah",
            "senderPhone" => "12563",
            "senderMail" => "Sarah@Connor.com",
            "message" => "Hello &lt;bold&gt;world!&lt;/bold&gt;",
            "dangerous" => "&lt;script&gt;alert(\'I ll be back!\');&lt;/script&gt;",
            "object" => (array)[
                "firstItem" => "anItem",
                "withAnArray" => [
                    "firstItem" => "OtherItem",
                    "andAnotherArray" => [
                        "andAlsoAnotherArray" => [
                            "anOtherItem" => "12345",
                            "andAnother" => "andAnotherItem",
                        ]
                    ]
                ]
            ]
            ,
            "boolean" => [
                "true" => true,
                "false" => false,
            ],
            "integer" => [
                "decimal" => "1234",
                "octal" => "83",
                "hexadecimal" => "26",
                "binary" => "255",
                "anOtherDecimal" => "1234567", // from PHP 7.4.0
            ],
            "float" => [
                "first" => "1.234",
                "second" => "1200",
                "third" => "7.0E-10",
                "fourth" => "1234.567", // from PHP 7.4.0
            ],
            "null" => null,
            "test" => "&lt;?php echo \'test\'",
            'escape' => "O\'Reilly?\\\/",
            "otherEscape" => 'Hello &quot;You&quot; !'
        ];
    }

    /**
     * @dataProvider provideTestMail
     *
     * @param $array
     *
     * @throws Exception
     */
    public function testMailException($array)
    {
        $data = new Post($array);
        $this->expectException(Exception::class);
        $data->getPost();
    }

    public function provideTestMail()
    {
        return [
            [["senderMail" => "badMail.com"]],
            [["senderMail" => "sarahConnor@skynet.co"]],
            // ! don't throw exeption without DNS check in Settings.php
            [["senderMail" => "@skynet.com"]],
            [["replyMail" => "badMail.com"]],
            [["replyMail" => "sarahConnor@skynet"]],
            [["replyMail" => "@skynet.com"]],
            [["recipientMail" => "badMail.com"]],
            [["recipientMail" => "sarahConnor@skynet"]],
            [["recipientMail" => "@skynet.com"]]
        ];
    }

}
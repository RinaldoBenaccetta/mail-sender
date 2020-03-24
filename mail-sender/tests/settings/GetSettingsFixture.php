<?php


namespace MailSenderTest\settings;


class GetSettingsFixture
{

    public array $one = [
        "oneOne" => "1.1",
        "oneTwo" => "1.2",
        "oneThree" => [
            "oneThreeOne" => "1.3.1",
            "oneThreeTwo" => "1.3.2",
        ]
    ];

    public array $two = [
        "twoOne" => "2.1",
        "twoTwo" => "2.2",
        "twoThree" => [
            "twoThreeOne" => "2.3.1",
            "twoThreeTwo" => "2.3.2",
        ]
    ];

    public array $three = [
        "threeOne" => "3.1",
        "threeTwo" => "3.2"
    ];

    public string $four = "a string";

    private array $five = [ // this should be ignored in the output.
        "fourOne" => "5.1",
        "fourTwo" => "5.2"
    ];

    protected array $six = [ // this should be ignored in the output.
        "fiveOne" => "6.1",
        "fiveTwo" => "6.2"
    ];

    public function testFunction()
    { // this should be ignored in the output.
        return "something";
    }
}
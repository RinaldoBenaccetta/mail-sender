<?php

require __DIR__ . "/../src/class/data/Post.php";

use MailSender\data\Post;


class SanitizePostTest extends PHPUnit\Framework\TestCase {

  /**
   * @dataProvider getTestSanitizeProvider
   *
   * @param $expected
   * @param $given
   */
  public function testSanitize($expected, $given) {

  }

  public function getTestSanitizeProvider() {
    return [
      $this->getExpected(), $this->getGiven()
    ];
  }

  public function getExpected() {
    return [
      "senderName" => "Connor",
      "senderFirstName" => "Sarah",
      "senderPhone" => "12563",
      "senderMail" => "Sarah@Connor.com",
      "message" => "Hello <bold>world!</bold>",
      "dangerous" => "<script>alert('I ll be back!');</script>",
      "array" => [
        "firstItem" => "an item",
        "SecondItem" => [
          "firstItem" => "an other item",
          "secondItem" => [
            "firstItem" => [
              "anOtherItem" => "12345"
            ]
          ]
        ]
      ]
    ];
  }

  public function getGiven() {
    return [
      "senderName" => "Connor",
      "senderFirstName" => "Sarah",
      "senderPhone" => 12563,
      "senderMail" => "Sarah@Connor.com",
      "message" => "Hello <bold>world!</bold>",
      "dangerous" => "<script>alert('I ll be back!');</script>",
      "array" => [
        "firstItem" => "an item",
        "SecondItem" => [
          "firstItem" => "an other item",
          "secondItem" => [
            "firstItem" => [
              "anOtherItem" => 12345
            ]
          ]
        ]
      ]
    ];
  }

}
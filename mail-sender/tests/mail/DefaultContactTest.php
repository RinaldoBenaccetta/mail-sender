<?php

use MailSender\mail\DefaultContact;

class DefaultContactTest extends PHPUnit\Framework\TestCase {

  /**
   * @dataProvider getGetNameProvider
   *
   * @param $firstName
   * @param $name
   * @param $expected
   */
  public function testGetName ($firstName, $name, $expected) {
    $this->assertEquals($expected, DefaultContact::getName((object) [
        'senderFirstName' => $firstName,
        'senderName' => $name,
      ]
    ));
  }

  /**
   * @return array
   */
  public function getGetNameProvider() {
    return [
      ['Sarah', 'Connor', 'Sarah Connor'],
      ['Sarah', NULL, 'Sarah'],
      [NULL, 'Connor', 'Connor'],
      [NULL, NULL, NULL],
    ];
  }

  public function testGetSubject () {
    $this->assertEquals(
      "Demande d'information de la part de Sarah Connor.", DefaultContact::getSubject((object) [
          'senderFirstName' => 'Sarah',
          'senderName' => 'Connor'
        ]
      ));
  }
}
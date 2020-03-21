<?php

use MailSender\render\Render;

/**
 * Class RenderTest
 */
class RenderTest extends PHPUnit\Framework\TestCase {

  /**
   * @dataProvider provideTestRender
   *
   * @param $template
   *
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function testRender($template) {
    $message = 'Hello';
    $name = 'Sarah Connor';
    $expected = "Hello <strong>Sarah Connor</strong>";

    $this->assertEquals($expected, Render::render(
      $template,
      [
        'message' => $message,
        'name' => $name
      ]
    ));
  }

  public function provideTestRender() {
    return [
      ['test-template'], // test without .twig extension
      ['test-template.twig'], // test with twig extension
    ];
  }

}
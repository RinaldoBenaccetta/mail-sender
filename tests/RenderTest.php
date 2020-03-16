<?php

require __DIR__ . "/../src/class/render/Render.php";
require __DIR__ . "/../src/class/settings/Settings.php";
require __DIR__ . "/../src/class/settings/GetSettings.php";

use MailSender\render\Render;

/**
 * Class RenderTest
 */
class RenderTest extends PHPUnit\Framework\TestCase {

  /**
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function testRender() {
    $template = 'test-template';
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

}
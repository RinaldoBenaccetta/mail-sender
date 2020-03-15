<?php


namespace MailSender\render;

use MailSender\Directories;


class Render {

  /**
   * Return the rendered HTML with the provided template and datas.
   *
   * @param $template
   * @param $data
   *
   * @return string
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public static function render($template, $data) {
    $loader = new \Twig\Loader\FilesystemLoader(Directories::TEMPLATES);

    $template = $template . '.twig';

    $twig = new \Twig\Environment($loader, [
      'debug' => TRUE,
      'cache' => FALSE, // no need of cache for mails : they are all differents.
    ]);

    return $twig->render($template, $data);
  }


}
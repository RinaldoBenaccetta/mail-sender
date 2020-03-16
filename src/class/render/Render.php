<?php


namespace MailSender\render;

use MailSender\Directories;
use MailSender\settings\GetSettings;
use Twig\Environment;


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

    $settings = GetSettings::getSettings();

    $twig = new Environment($loader, [
      'debug' => self::getDebug($settings->global->environment),
      'cache' => FALSE, // no need of cache for mails : they are all differents.
    ]);

    return $twig->render($template, $data);
  }

  /**
   * @param string $environment
   *
   * @return bool
   */
  private static function getDebug(string $environment) : bool {
    if (!empty($environment) && $environment === 'dev' ) {
      return TRUE;
    }
    Return FALSE;
  }


}
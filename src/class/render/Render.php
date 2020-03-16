<?php


namespace MailSender\render;

use MailSender\Directories;
use MailSender\settings\GetSettings;
use MailSender\tools\StringTool;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class Render {

  /**
   * Return the rendered HTML with the provided template and datas.
   * The .twig extension can be forgeted for $template argument.
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
    $loader = new FilesystemLoader(Directories::TEMPLATES);

    $template = self::getTemplateFile($template);

    $settings = GetSettings::getSettings();

    $twig = new Environment($loader, [
      'debug' => self::getDebug($settings->global->environment),
      'cache' => FALSE, // no need of cache for mails : they are all differents.
    ]);

    return $twig->render($template, $data);
  }

  /**
   * Return the twig's debug value in terms of environment.
   * Return TRUE if in dev environment.
   * Return FALSE if not in dev environment.
   *
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

  /**
   * Return the file's name of the template provided.
   * Let the possibility of forget the .twig extension.
   *
   * Add .twig at the end if have not.
   *
   * @param string $template
   *
   * @return string
   */
  private static function getTemplateFile(string $template) : string {
    if (StringTool::endsWith($template, '.twig')) {
      return $template;
    }
    return $template . '.twig';
  }



}
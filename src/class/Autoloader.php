<?php

namespace MailSender;

/**
 * Class Autoloader
 *
 * from https://www.grafikart.fr/tutoriels/autoload-561
 * and https://www.youtube.com/watch?v=dV4jgx5b4gk
 *
 */
class Autoloader {

  /**
   * save the autoloader.
   */
  static function register(){
    spl_autoload_register(array(__CLASS__, 'autoload'));
    // 'autoload' is for calling autoload method
  }

  /**
   * Include corresponding class's file.
   * @param $class string The class name
   */
  static function autoload($class) {
    $class = str_replace(__NAMESPACE__, '', $class);
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $class = __DIR__ . $class . '.php';
    if (file_exists($class)) {
      require $class;
    }

  }

}
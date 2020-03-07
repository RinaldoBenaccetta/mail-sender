<?php

/**
 * Class Autoloader
 *
 * from https://www.grafikart.fr/tutoriels/autoload-561
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
  static function autoload($class){
    require 'class/' . $class . '.php';
  }

}
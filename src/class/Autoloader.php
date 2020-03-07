<?php


class Autoloader {

  /**
   * save the autoloader
   */
  static function register(){
    spl_autoload_register(array(__CLASS__, 'autoload'));
  }

  /**
   * Include corresponding class's file.
   * @param $class string The class name
   */
  static function autoload($class){
    require 'class/' . $class . '.php';
  }

}
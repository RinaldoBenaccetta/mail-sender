<?php


namespace MailSender\settings;

/**
 * Class GetSettings
 *
 * @package MailSender\settings
 */
class GetConfig extends Config{

  /**
   * Return an object with all the settings of the application.
   *
   * use exemple :
   *     $this->_settings = GetSettings::getSettings();
   *     $environment = $this->_settings->global->environment
   *
   * @return object
   */
  public static function getSettings() {
    $output = [];
    $settings = new Config();
    foreach ($settings as $key => $value) {
      $output[$key] = (object) $value;
    }
    return (object) $output;
  }

}

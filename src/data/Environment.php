<?php


namespace MailSender\data;


use Dotenv\Dotenv;
use MailSender\Path;
use MailSender\settings\GetConfig;

class Environment {

  private object $_settings;

  private array $_environment;


  public function __construct() {
    $this->setSettings();
    $this->setServer();
  }

  public function getEnvironment() {
    return $this->_environment;
  }

  protected function setSettings() {
    return $this->_settings = GetConfig::getSettings();
  }

  protected function setServer() {
    $dotEnv             = Dotenv::createImmutable(Path::ROOT_PATH . $this->getRootParent());
    $this->_environment = $dotEnv->load();
  }

  protected function getRootParent() {
    $repeat = 1 + $this->_settings->global->rootParent;
    if ($repeat < 1) {
      $repeat = 1;
    }
    return str_repeat('/..', $repeat) . '/';
  }

}
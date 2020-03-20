<?php

namespace MailSender\data;

/**
 * Class Server
 *
 * @package MailSender\data
 */
class Server {

  /**
   * @var array
   */
  private array $_environment;

  /**
   * Server constructor.
   */
  public function __construct() {
    $this->setEnvironmentSettings();
  }

  /**
   *
   */
  protected function setEnvironmentSettings() {
    $environment = new Environment();
    $this->_environment = $environment->getEnvironment();
  }

  /**
   * Return an object with the values to access server
   * provided in the .env file.
   * 
   * Use like this :
   *     $server->getServerSettings()->host
   *
   * @return object
   */
  public function getServerSettings(): object {
    return (object) [
      'host' => (string) $this->_environment['HOST'],
      'port' => (string) $this->_environment['PORT'],
      'encryption' => (string) $this->_environment['ENCRYPTION'],
      'smtpAuthentication' => (bool)filter_var($this->_environment['SMTP_AUTHENTICATION'], FILTER_VALIDATE_BOOLEAN),// transform to bool
      'mailLogin' => (string) $this->_environment['MAIL_LOGIN'],
      'mailPassword' => (string) $this->_environment['MAIL_PASSWORD'],
    ];
  }

}
<?php

namespace MailSender\data;


class Server {

  private array $_environment;

  public function __construct() {
    $this->setEnvironmentSettings();
  }

  protected function setEnvironmentSettings() {
    $environment = new Environment();
    $this->_environment = $environment->getEnvironment();
  }

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
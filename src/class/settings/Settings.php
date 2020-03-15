<?php


namespace MailSender\settings;

/**
 * Class Settings
 *
 * List of settings of all mail-sender application.
 * Modify the settings on this file.
 *
 * @package MailSender\settings
 */
class Settings {

  /**
   * Here is the global settings.
   *
   * @var array
   */
  protected array $global = [
    'environment' => 'dev', // 'dev' | 'production'
    'debug' => 'server',
  ];

  /**
   * Here is the options for the server infos.
   *
   * @var array
   */
  protected array $mailServer = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'encryption' => 'STARTTLS', // 'STARTTLS' | 'SMTPS'
    'smtpAuthentication' => TRUE,
    'mailLogin' => 'benaccettarinaldo@gmail.com',
    'mailPassword' => 'vivelaneigeDejuin',
  ];

  /**
   * Here is the options for the default mail options.
   * If nothing is provided when sending mail,
   * then theses settings will be used.
   *
   * Eg. : if ne sender mail is not provided,
   * defaultMailOptions->senderMail will be used.
   *
   * @var array
   */
  protected array $defaultMailOptions = [

    'template' => 'contact-default', // Default template. Without the .twig suffix
    'senderMail' => 'rinaldobenaccetta@hotmail.com',
    'senderName' => 'Rinaldo Benaccetta',
    'recipientMail' => 'rinaldobenaccetta@hotmail.com',
    'recipientName' => 'Rinaldo Benaccetta',
    'subject' => 'Le sujet!',
  ];

  /**
   * Here is the settings for the default template.
   *
   * @var array
   */
  protected array $defaultContactTemlate = [
    'subjectPrefix' => "Demande d'information de la part de",
    'subjectSuffix' => ".",
  ];

}
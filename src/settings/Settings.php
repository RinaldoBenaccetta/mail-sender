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
class Config {

  /**
   * Here is the global settings.
   *
   * @var array
   */
  protected array $global = [
    'environment' => 'dev', // 'dev' | 'prod'
    'rootParent' => '0',
  ];

  /**
   * Here is the options for the server infos.
   *
   * @var array
   */
  protected array $mailServer = [
    /**
     * The host of the mail server.
     */
    'host' => 'smtp.gmail.com',
    /**
     * The port used to send mails.
     */
    'port' => 587,
    /**
     * The encryption method.
     * 'STARTTLS' | 'SMTPS'
     */
    'encryption' => 'STARTTLS',
    /**
     * Is the smtp authentication must be used?
     */
    'smtpAuthentication' => TRUE,
    /**
     * The login used to connect to mail server.
     */
    'mailLogin' => 'benaccettarinaldo@gmail.com',
    /**
     * The password used to connect to mail server.
     */
    'mailPassword' => 'vivelaneigeDejuin', // todo : make this more secure, ideally found it in the environment variable.
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
    /**
     * Default template. Without the .twig suffix.
     */
    'template' => 'contact-default',
    /*
     * Default sender mail.
     */
    'senderMail' => 'rinaldobenaccetta@hotmail.com',
    /**
     * Default sender name.
     */
    'senderName' => 'Rinaldo Benaccetta',
    /**
     * Default recipient mail.
     */
    'recipientMail' => 'rinaldobenaccetta@hotmail.com',
    /**
     * Default recipient name.
     */
    'recipientName' => 'Rinaldo Benaccetta',
    /**
     * Default subject.
     */
    'subject' => 'Le sujet!',
  ];

  /**
   * Here is the validations rules for $POST values.
   *
   * @var array
   */
  protected array $validation = [
    /**
     * Theses $POST's values will be validated for correct mail address.
     * If a value must be validated as an e-mail address,
     * it must be here.
     *
     */
    'isMail' => [
      'senderMail',
      'replyMail',
      'recipientMail'
    ],
    /**
     * enable or disable DNS validation for mail addresses.
     */
    'DNSMailValidation' => TRUE,
    /**
     * enable or disable spoof validation for mail addresses.
     */
    'SpoofMailValidation' => TRUE,
  ];

  /**
   * Here is the settings for the default template.
   *
   * @var array
   */
  protected array $defaultContactTemlate = [
    /**
     * The prefix for the subject in the default template.
     * The sender name provided in the $POST values will
     * be after the prefix.
     */
    'subjectPrefix' => "Demande d'information de la part de",
    /**
     * The suffix for the subject in the default template.
     * The sender name provided in the $POST values will
     * be before the suffix.
     */
    'subjectSuffix' => ".",
  ];

}
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
class Settings
{

    /**
     * Here is the global settings.
     *
     * @var array
     */
    public array $global = [
        'environment' => 'prod', // 'dev' | 'prod'
        'rootParent' => '1',
    ];

    /**
     * Here is responses of server.
     *
     * @var array
     */
    public array $response = [
        /**
         * The message sended back by Ajax when mail is sended without error.
         */
        'success' => 'ok',
        /**
         * The message sended back when an error occur.
         */
        'error' => 'error',
    ];

    /**
     * List of severity of errors.
     *
     * @var array
     */
    public array $severity = [
        /**
         * Uncomment desired notice.
         */
      'list' => [
          //'debug',
          //'info',
          //'notice',
          'warning',
          'error',
          'critical',
          'alert',
          'emergency',
      ]
    ];

    /**
     * Here is the redirection pages links.
     * Put them here and access them like this :
     * $settings->redirect->myPage
     *
     * The links are from mail-sender/src folder + htmlRootParent.
     *
     * Redirect class will use the page value
     * and prefix it with '../' multiplied by htmlRootParent.
     *
     * @var array
     */
    public array $redirect = [
        /**
         * The default page for redirect when there are an error.
         */
        'defaultMailErrorPage' => 'mail-error.html',
        /**
         * The default page for redirect when the mail is sends.
         */
        'defaultMailOkPage' => 'thank-you.html',
        /**
         * Here is the number of parents from the root of
         * mail-sender to find the root of html.
         */
        'htmlRootParent' => '1',
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
    public array $defaultMailOptions = [
        /**
         * Default template. Without the .twig suffix.
         */
        'template' => 'contact-default',
        /*
         * Default sender mail. This will be displayed as the sender mail in
         * the mailbox of the recipient.
         * This is not the mail of the server mail.
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
    public array $validation = [
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
        'DNSMailValidation' => true,
        /**
         * enable or disable spoof validation for mail addresses.
         */
        'SpoofMailValidation' => true,
    ];

    /**
     * Here is the settings for the default template.
     *
     * @var array
     */
    public array $defaultContactTemplate = [
        /**
         * The prefix for the subject in the default template.
         * The sender name provided in the $POST values will
         * be after the prefix.
         */
        'subjectPrefix' => "Demande d'information de la part de ",
        /**
         * The suffix for the subject in the default template.
         * The sender name provided in the $POST values will
         * be before the suffix.
         */
        'subjectSuffix' => ".",
    ];

}
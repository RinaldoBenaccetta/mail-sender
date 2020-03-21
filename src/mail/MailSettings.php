<?php


namespace MailSender\mail;

use MailSender\render\Render;
use MailSender\settings\GetSettings;
use MailSender\data\Server;

// todo : set server info from _server

/**
 * Class MailSettings
 *
 * Filter and complete the values provided by $POST.
 *
 *
 * @package MailSender\mail
 */
class MailSettings
{

    /**
     * Containing post values provided.
     *
     * @var object
     */
    private object $_post;

    /**
     * Containing the options provided by MailOptions class.
     *
     * @var object
     */
    private object $_options;

    /**
     * The settings imported from Settings class.
     *
     * @var object
     */
    private object $_settings;

    /**
     * The values for connecting to the server.
     * @var object
     */
    private object $_server;


    public function __construct($post)
    {
        $this->setSettings();
        $this->setPost($post);
        $this->setOptions();
        $this->setServer();
    }

    /**
     *
     */
    protected function setSettings(): void
    {
        $this->_settings = GetSettings::getSettings();
    }

    /**
     * @param $post
     */
    protected function setPost($post): void
    {
        $this->_post = (object) $post;
    }

    /**
     *
     */
    protected function setOptions(): void
    {
        $mailOptions = new MailOptions($this->_post);
        $this->_options = (object) $mailOptions->getOptions();
    }

    /**
     *
     */
    protected function setServer(): void
    {
        $server = new Server();
        $this->_server = $server->getServerSettings();
    }

    /**
     * Return an array with all the settings of the e-mail.
     *
     * @return array
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAll()
    {
        return [
            'host' => $this->getHost(),
            'port' => $this->getPort(),
            'encryptionMethod' => $this->getEncryption(),
            'smtpAuthentication' => $this->getSmtpAuthentication(),
            'mailLogin' => $this->getMailLogin(),
            'mailPassword' => $this->getMailPassword(),
            'senderMail' => $this->getSenderMail(),
            'senderName' => $this->getSenderName(),
            'replyMail' => $this->getReplyMAil(),
            'replyName' => $this->getReplyName(),
            'recipientMail' => $this->getRecipientMail(),
            'recipientName' => $this->getRecipientMail(),
            'debug' => $this->getDebug(),
            'subject' => $this->getSubject(),
            'htmlBody' => $this->getHtmlBody(),
            'altBody' => $this->getAltBody(),
        ];
    }

    /**
     * Return host from settings/GetSettings.
     *
     * @return mixed
     */
    public function getHost()
    {
        return $this->_server->host;
        //return $this->_settings->mailServer->host;
    }

    /**
     * Return port from settings/GetSettings.
     *
     * @return mixed
     */
    public function getPort()
    {
        return $this->_server->port;
        //return $this->_settings->mailServer->port;
    }

    /**
     * Return encryption from settings/GetSettings.
     *
     * @return mixed
     */
    public function getEncryption()
    {
        return $this->_server->encryption;
        //return $this->_settings->mailServer->encryption;
    }

    /**
     * Return smtp authentication from settings/GetSettings.
     *
     * @return mixed
     */
    public function getSmtpAuthentication()
    {
        return $this->_server->smtpAuthentication;
        //return $this->_settings->mailServer->smtpAuthentication;
    }

    /**
     * Return mail login from settings/GetSettings.
     *
     * @return mixed
     */
    public function getMailLogin()
    {
        return $this->_server->mailLogin;
        //return $this->_settings->mailServer->mailLogin;
    }

    /**
     * Return mail password from settings/GetSettings.
     *
     * @return mixed
     */
    // todo : improve security on this.
    public function getMailPassword()
    {
        return $this->_server->mailPassword;
        //return $this->_settings->mailServer->mailPassword;
    }

    /**
     * Return sender mail from POST
     * OR
     * Return default sender mail from settings/GetSettings
     * According to MailOptions class.
     *
     * @return string|null
     */
    public function getSenderMail()
    {
        if (!empty($this->_options->senderMail)) {
            return $this->_options->senderMail;
        }
        return null;
    }

    /**
     * Return sender name from POST.
     * OR
     * Return default sender name from settings/GetSettings
     * According to MailOptions class.
     *
     * @return string|null
     */
    public function getSenderName()
    {
        if (!empty($this->_options->senderName)) {
            return $this->_options->senderName;
        }
        return null;
    }

    /**
     * Return reply mail from POST.
     * OR
     * Return default sender mail from settings/GetSettings
     * According to MailOptions class.
     *
     * @return string|null
     */
    public function getReplyMail()
    {
        if (!empty($this->_post->replyMail)) {
            return $this->_post->replyMail;
        }
        return null;
    }

    /**
     * Return reply name from POST.
     * OR
     * Return default sender name from settings/GetSettings
     * According to MailOptions class.
     *
     * @return string|null
     */
    public function getReplyName()
    {
        if (!empty($this->_post->replyName)) {
            return $this->_post->replyName;
        }
        return null;
    }

    /**
     * Return recipient mail from POST.
     * OR
     * Return default recipient mail from settings/GetSettings
     * According to MailOptions class.
     *
     * @return string|null
     */
    public function getRecipientMail()
    {
        if (!empty($this->_options->recipientMail)) {
            return $this->_options->recipientMail;
        }
        return null;
    }

    /**
     * Return recipient name from POST.
     * OR
     * Return default recipient name from settings/GetSettings
     * According to MailOptions class.
     *
     * @return string|null
     */
    public function getRecipientName()
    {
        if (!empty($this->_options->recipientName)) {
            return $this->_options->recipientName;
        }
        return null;
    }

    /**
     * Return debug for PHPMailer
     * in terms of environment from settings/GetSettings.
     * 'dev' will return 'server'.
     * other will return 'off'.
     *
     * @return string
     */
    public function getDebug()
    {
        $environment = null;
        if (!empty($this->_settings->global->environment)) {
            $environment = $this->_settings->global->environment;
        }
        switch ($environment) {
            case 'dev':
                return 'server';
                break;

            case 'prod':
                return 'off';
                break;

            default:
                return 'off';
        }
    }

    /**
     * Return subject from POST
     * OR
     * Return subject according to setSubject from MailOptions class.
     *
     * @return string|null
     */
    public function getSubject()
    {
        if (!empty($this->_options->subject)) {
            return $this->_options->subject;
        }
        return null;
    }

    /**
     * Return the HTML body with the variables provided in post
     * and with the template provided in post.
     * If no template is provided in POST,
     * the default template will be used.
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getHtmlBody()
    {
        $template = $this->_options->template;
        $data = (array)$this->_post;
        return Render::render($template, $data);
    }

    /**
     * Return the alternative body provided in POST.
     *
     * @return string|null
     */
    public function getAltBody()
    {
        if (property_exists($this->_post, 'altBody')) {
            return $this->_post->altBody;
        } else {
            return null;
        }
    }

}
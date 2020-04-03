<?php


namespace MailSender\mail;

use Exception;
use MailSender\data\EnvironmentInterface;
use MailSender\data\ServerInterface;
use MailSender\exception\RenderException;
use MailSender\render\Render;

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
    private object $_environment;


    /**
     * MailSettings constructor.
     *
     * @param EnvironmentInterface $environment
     * @param MailOptionsInterface $mailOptions
     */
    public function __construct(
        EnvironmentInterface $environment,
        MailOptionsInterface $mailOptions
    ) {
        $this->setSettings($mailOptions);
        $this->setPost($mailOptions);
        $this->setOptions($mailOptions);
        $this->setEnvironment($environment);
    }

    /**
     * @param MailOptionsInterface $mailOptions
     */
    protected function setSettings(MailOptionsInterface $mailOptions): void
    {
        $this->_settings = $mailOptions->getSettings();
    }

    /**
     * @param MailOptionsInterface $mailOptions
     */
    protected function setPost(MailOptionsInterface $mailOptions): void
    {
        $this->_post = $mailOptions->getPost();
    }

    /**
     * @param MailOptionsInterface $mailOptions
     */
    protected function setOptions(MailOptionsInterface $mailOptions): void
    {
        $this->_options = (object)$mailOptions->getOptions();
    }

    /**
     * @param EnvironmentInterface $environment
     */
    protected function setEnvironment(EnvironmentInterface $environment): void
    {
        $this->_environment = $environment->getEnvironmentObject();
    }

    /**
     * Return an array with all the settings of the e-mail.
     *
     * @return array
     * @throws RenderException
     */
    public function getAll(): array
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
        return $this->_environment->host;
    }

    /**
     * Return port from settings/GetSettings.
     *
     * @return mixed
     */
    public function getPort()
    {
        return $this->_environment->port;
    }

    /**
     * Return encryption from settings/GetSettings.
     *
     * @return mixed
     */
    public function getEncryption()
    {
        return $this->_environment->encryption;
    }

    /**
     * Return smtp authentication from settings/GetSettings.
     *
     * @return mixed
     */
    public function getSmtpAuthentication()
    {
        return $this->_environment->smtpAuthentication;
    }

    /**
     * Return mail login from settings/GetSettings.
     *
     * @return mixed
     */
    public function getMailLogin()
    {
        return $this->_environment->mailLogin;
    }

    /**
     * Return mail password from settings/GetSettings.
     *
     * @return mixed
     */
    public function getMailPassword()
    {
        return $this->_environment->mailPassword;
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
     * @throws RenderException
     */
    public function getHtmlBody()
    {
        $template = $this->_options->template;
        $data = (array)$this->_post;
        try {
            return Render::render($template, $data, $this->_settings);
        } catch (Exception $e) {
            throw new RenderException($e->getMessage());
        }
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

}
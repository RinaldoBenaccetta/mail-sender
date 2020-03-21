<?php


namespace MailSender\mail;

use MailSender\settings\GetSettings;

/**
 * Class MailOptions
 *
 * @package MailSender\mail
 */
class MailOptions
{

    /**
     * The template.
     *
     * @var string
     */
    private string $_template;

    /**
     * The sender's mail.
     *
     * @var string
     */
    private string $_senderMail;

    /**
     * The sender's name.
     *
     * @var string
     */
    private string $_senderName;

    /**
     * The recipient's mail.
     *
     * @var string
     */
    private string $_recipientMail;

    /**
     * The recipient's name.
     *
     * @var string
     */
    private string $_recipientName;

    /**
     * The subject.
     *
     * @var string
     */
    private string $_subject;

    /**
     * The settings provided at creation of the object.
     *
     * @var object
     */
    private object $_post;

    /**
     * The settings imported from Settings class.
     *
     * @var object
     */
    private object $_settings;

    /**
     * MailOptions constructor.
     *
     * @param object $post
     */
    public function __construct(object $post)
    {
        $this->_settings = GetSettings::getSettings();
        $this->_post = $post;
        $this->setOptions();
    }

    /**
     * Return the options for rendering.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'template' => $this->_template,
            'senderMail' => $this->_senderMail,
            'senderName' => $this->_senderName,
            'recipientMail' => $this->_recipientMail,
            'recipientName' => $this->_recipientName,
            'subject' => $this->_subject,
        ];
    }

    /*
     * Set the options with infos contained in _post.
     */
    protected function setOptions(): void
    {
        $this->setTemplate();
        $this->setSenderMail();
        $this->setSenderName();
        $this->setRecipientMail();
        $this->setRecipientName();
        $this->setSubject();
    }


    /**
     * Define the template.
     * If a template is provided, it will be used,
     * if not, the default template will be used.
     */
    protected function setTemplate(): void
    {
        if (!empty($this->_post->template)) {
            $this->_template = $this->_post->template;
        } else {
            $this->_template = $this->_settings->defaultMailOptions->template;
        }
    }

    /**
     * Define the sender E-mail.
     * If a sender E-mail is provided, it will be used,
     * if not, the default sender E-mail will be used.
     */
    protected function setSenderMail(): void
    {
        if (!empty($this->_post->senderMail)) {
            $this->_senderMail = $this->_post->senderMail;
        } else {
            $this->_senderMail = $this->_settings->defaultMailOptions->senderMail;
        }
    }

    /**
     * Define the sender name.
     * If a sender name is provided, it will be used,
     * is not, the default sender name will be used.
     */
    protected function setSenderName(): void
    {
        if (!empty($this->_template)
            && !empty($this->_post->senderName)
            && $this->_template === $this->_settings->defaultMailOptions->template) {
            // if template is the default one, the name is built for it
            $this->_senderName = DefaultContact::getName($this->_post);
            //$this->_senderName = $this->_post->senderName;
        } elseif (!empty($this->_post->senderName)) {
            // if there is a sender name in post, use it
            $this->_senderName = $this->_post->senderName;
        } else {
            // if there is no sender name in post and is not default template
            // use the default sender name
            $this->_senderName = $this->_settings->defaultMailOptions->senderName;
        }
    }

    /**
     * Define the recipient E-mail.
     * If a recipient E-mail is provided, it will be used,
     * is not, the default recipient E-mail will be used.
     */
    protected function setRecipientMail(): void
    {
        if (!empty($this->_post->recipientMail)) {
            $this->_recipientMail = $this->_post->recipientMail;
        } else {
            $this->_recipientMail = $this->_settings->defaultMailOptions->recipientMail;
        }
    }

    /**
     * Define the recipient name.
     * If a recipient name is provided, it will be used,
     * is not, the default recipient name will be used.
     */
    protected function setRecipientName(): void
    {
        if (!empty($this->_post->recipientName)) {
            $this->_recipientName = $this->_post->recipientName;
        } else {
            $this->_recipientName = $this->_settings->defaultMailOptions->recipientName;
        }
    }

    /**
     * Define the subject.
     * If a subject is provided, it will be used,
     * is not, the default subject will be used.
     */
    protected function setSubject(): void
    {
        // if template is empty : set it.
        if (empty($this->_template)) {
            $this->setTemplate();
        }

        $defaultTemplate = $this->_settings->defaultMailOptions->template;

        if ($this->_template === $defaultTemplate
            && empty($this->_post->senderName)
        ) {
            // if this is default template and not have sender name
            $this->_subject = DefaultContact::getSubject(
                (object)['senderName' => $this->_settings->defaultMailOptions->senderName]
            );
        } elseif ($this->_template === $defaultTemplate
            && !empty($this->_post->senderName)
        ) {
            // if this is default template and have sender name
            $this->_subject = DefaultContact::getSubject($this->_post);
        } elseif ($this->_template != $defaultTemplate
            && !empty($this->_post->subject)
        ) {
            // if this is not default template and have a post subject
            $this->_subject = $this->_post->subject;
        } else {
            // if this is not default template and have not a post subject
            $this->_subject = $this->_settings->defaultMailOptions->subject;
        }
    }

}
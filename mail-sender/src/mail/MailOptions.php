<?php


namespace MailSender\mail;

use Exception;
use MailSender\data\PostInterface;
use MailSender\exception\ForgottenOptionException;

/**
 * Class MailOptions
 *
 * @package MailSender\mail
 */
class MailOptions implements MailOptionsInterface
{
    /**
     * The default template name.
     */
    const CONTACT_DEFAULT = 'contact-default';

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
     * @param PostInterface $post
     * @param object $settings
     * @throws Exception
     */
    public function __construct(PostInterface $post, object $settings)
    {
        $this->_settings = $settings;
        $this->setPost($post);
        $this->setOptions();
    }

    /**
     * @param PostInterface $post
     * @throws Exception
     */
    public function setPost(PostInterface $post): void {
        $this->_post = (object) $post->getPost();
    }

    /**
     * @throws ForgottenOptionException
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

    /*
     * Set the options with infos contained in _post.
     */

    /**
     * Define the template.
     * If a template is provided, it will be used,
     * if not, the default template will be used.
     * @throws ForgottenOptionException
     */
    protected function setTemplate(): void
    {
        if (!empty($this->_post->template)) {
            $this->_template = $this->_post->template;
        } elseif(!empty($this->_settings->defaultMailOptions->template)) {
            $this->_template = $this->_settings->defaultMailOptions->template;
        } else {
            throw new ForgottenOptionException('Empty template.', 5060);
        }
    }

    /**
     * Define the sender E-mail.
     * If a sender E-mail is provided, it will be used,
     * if not, the default sender E-mail will be used.
     * @throws ForgottenOptionException
     */
    protected function setSenderMail(): void
    {
        if (!empty($this->_post->senderMail)) {
            $this->_senderMail = $this->_post->senderMail;
        } elseif (!empty($this->_settings->defaultMailOptions->senderMail)) {
            $this->_senderMail = $this->_settings->defaultMailOptions->senderMail;
        }
        else {
            throw new ForgottenOptionException('Empty sender mail.', 5020);
        }
    }

    /**
     * Define the sender name.
     * If a sender name is provided, it will be used,
     * is not, the default sender name will be used.
     * @throws ForgottenOptionException
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
        } elseif (!empty($this->_settings->defaultMailOptions->senderName)) {
            // if there is no sender name in post and is not default template
            // use the default sender name
            $this->_senderName = $this->_settings->defaultMailOptions->senderName;
        }
        else {
            // if empty throw exception
            throw new ForgottenOptionException('Empty sender name.', 5010);
        }
    }

    /**
     * Define the recipient E-mail.
     * If a recipient E-mail is provided, it will be used,
     * is not, the default recipient E-mail will be used.
     * @throws ForgottenOptionException
     */
    protected function setRecipientMail(): void
    {
        if (!empty($this->_post->recipientMail)) {
            $this->_recipientMail = $this->_post->recipientMail;
        } elseif(!empty($this->_settings->defaultMailOptions->recipientMail)) {
            $this->_recipientMail = $this->_settings->defaultMailOptions->recipientMail;
        } else {
            throw new ForgottenOptionException('Empty recipient mail.', 5040);
        }
    }

    /**
     * Define the recipient name.
     * If a recipient name is provided, it will be used,
     * is not, the default recipient name will be used.
     * @throws ForgottenOptionException
     */
    protected function setRecipientName(): void
    {
        if (!empty($this->_post->recipientName)) {
            $this->_recipientName = $this->_post->recipientName;
        } elseif (!empty($this->_settings->defaultMailOptions->recipientName)) {
            $this->_recipientName = $this->_settings->defaultMailOptions->recipientName;
        } else {
            throw new ForgottenOptionException('Empty recipient name.', 5030);
        }
    }

    /**
     * Define the subject.
     * If a subject is provided, it will be used,
     * is not, the default subject will be used.
     * @throws ForgottenOptionException
     */
    protected function setSubject(): void
    {
        // if template is empty : set it.
        if (empty($this->_template)) {
            $this->setTemplate();
        }

        if ($this->isDefaultTemplate(
                $this->_template
            ) && empty($this->_post->senderName)
        ) {
            // if this is default template and not have sender name
            $this->_subject = DefaultContact::getSubject(
                (object)[
                    'senderName' =>
                        $this->_settings->defaultMailOptions->senderName
                ],
                $this->_settings
            );
        } elseif ($this->isDefaultTemplate($this->_template)
            && !empty($this->_post->senderName)
        ) {
            // if this is default template and have sender name
            $this->_subject = DefaultContact::getSubject(
                $this->_post,
                $this->_settings
            );
        } elseif (!$this->isDefaultTemplate($this->_template)
            && !empty($this->_post->subject)
        ) {
            // if this is not default template and have a post subject
            $this->_subject = $this->_post->subject;
        } elseif (!empty($this->_settings->defaultMailOptions->subject)) {
            // if this is not default template and have not a post subject
            $this->_subject = $this->_settings->defaultMailOptions->subject;
        } else {
            throw new ForgottenOptionException('Empty subject.', 5050);
        }
    }

    /**
     * Define if template is contact-default.
     * It is not in reference of defaultMailOptions in class Settings.
     *
     * @param $template
     * @return bool
     */
    protected function isDefaultTemplate($template)
    {
        if ($template === self::CONTACT_DEFAULT) {
            return true;
        }
        return false;
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

    /**
     * Return the settings of the app.
     *
     * @return object
     */
    public function getSettings(): object
    {
        return $this->_settings;
    }

    /**
     * Return the sanitized and validated $_POST.
     * 
     * @return object
     */
    public function getPost(): object
    {
        return $this->_post;
    }

}
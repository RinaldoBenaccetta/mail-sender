<?php


namespace MailSender\mail;

use MailSender\settings\GetSettings;
use MailSender\settings\Settings;
use MailSender\tools\Debug;

/**
 * Class MailOptions
 *
 * @package MailSender\mail
 */
class MailOptions {

  private string $_template;
  private string $_senderMail;
  private string $_senderName;
  private string $_recipientMail;
  private string $_recipientName;
  private string $_subject;
  private object $_post;
  private object $_settings;

  /**
   * MailOptions constructor.
   *
   * @param object $post
   */
  public function __construct(object $post) {
    $this->_settings = GetSettings::getSettings();
    $this->_post = $post;
    $this->setOptions();
  }

  /**
   * Return the options for rendering.
   *
   * @return array
   */
  public function getOptions(): array {
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
   * Set the options.
   */
  private function setOptions(): void {
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
  private function setTemplate(): void {
    if (isset($this->_post->template) && !is_null($this->_post->template)) {
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
  private function setSenderMail(): void {
    if (isset($this->_post->senderMail) && !is_null($this->_post->senderMail)) {
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
  private function setSenderName(): void {
    $name = $this->_post->senderName;
    if ($this->_template === $this->_settings->defaultMailOptions->template) {
      $name = DefaultContact::getName($this->_post);
    }
    if (!is_null($name)) {
      $this->_senderName = $name;
    } else {
      $this->_senderName = $this->_settings->defaultMailOptions->senderName;
    }
  }

  /**
   * Define the recipient E-mail.
   * If a recipient E-mail is provided, it will be used,
   * is not, the default recipient E-mail will be used.
   */
  private function setRecipientMail(): void {
    if (isset($this->_post->recipientMail) && !is_null($this->_post->recipientMail)) {
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
  private function setRecipientName(): void {
    if (isset($this->_post->recipientName) && !is_null($this->_post->recipientName)) {
      $this->_recipientName = $this->_post->recipientName;
    } else {
      $this->_recipientName = $this->_settings->defaultMailOptions->recipientName;
    }
  }

  /**
   * Define the subject.
   * If a subjectl is provided, it will be used,
   * is not, the default subject will be used.
   */
  private function setSubject(): void {
    $defaultTemplate = $this->_settings->defaultMailOptions->template;
    if ($this->_template === $defaultTemplate) {
      // if this is default template
      $this->_subject = DefaultContact::getSubject($this->_post);
    } elseif ($this->_template != $defaultTemplate && isset($this->_post->subject) && !is_null($this->_post->subject)) {
      // if this is not default template and have a post subject
      $this->_subject = $this->_post->subject;
    } else {
      // if this is not default template and have not a post subject
      $this->_subject = $this->_settings->defaultMailOptions->subject;
    }
  }

}
<?php


namespace MailSender\mail;

use MailSender\mail\MailOptions;
use MailSender\render\Render;
use MailSender\Tools\Tools;

class MailSettings {

  // global
  const DEBUG = 'server'; // off | client | server

  // DB
  const HOST = 'smtp.gmail.com';
  const PORT = 587;
  const ENCRYPTION = 'STARTTLS'; // STARTTLS or SMTPS
  const SMTP_AUTHENTICATION = TRUE;
  const MAIL_LOGIN = 'benaccettarinaldo@gmail.com';

  // sensible
  const MAIL_PASSWORD = 'vivelaneigeDejuin';

  private $post;
  private $options;

  public function __construct($post) {
    // todo : validate post

    $this->post = $this->getPost($post);
    $this->options = $this->getOptions($this->post);
  }

  private function getOptions($options) {
    $mailOptions = new MailOptions($options);
    return (object) $mailOptions->getOptions();
  }

  private function getPost($post) {
    return (object) $post;
  }

  public function getHost() {
    return self::HOST;
  }

  public function getPort() {
    return self::PORT;
  }

  public function getEncryption() {
    return self::ENCRYPTION;
  }

  public function getSmtpAuthentication() {
    return self::SMTP_AUTHENTICATION;
  }

  public function getMailLogin() {
    return self::MAIL_LOGIN;
  }

  public function getMailPassword() {
    return self::MAIL_PASSWORD;
  }

  public function getSenderMail() {
    if (isset($this->options->senderMail) && !is_null($this->options->senderMail)) {
      return $this->options->senderMail;
    }
    return NULL;
  }

  public function getSenderName() {
    if (isset($this->options->senderName) && !is_null($this->options->senderName)) {
      return $this->options->senderName;
    }
    return NULL;
  }

  public function getReplyMail() {
    if (isset($this->post->replyMail) && !is_null($this->post->replyMail)) {
      return $this->post->replyMail;
    }
    return NULL;
  }

  public function getReplyName() {
    if (isset($this->post->replyName) && !is_null($this->post->replyName)) {
      return $this->post->replyName;
    }
    return NULL;
  }

  public function getRecipientMail() {
    if (isset($this->options->recipientMail) && !is_null($this->options->recipientMail)) {
      return $this->options->recipientMail;
    }
    return NULL;
  }

  public function getRecipientName() {
    if (isset($this->options->recipientName) && !is_null($this->options->recipientName)) {
      return $this->options->recipientName;
    }
    return NULL;
  }

  public function getDebug() {
    return self::DEBUG;
  }

  public function getSubject() {
    if (isset($this->options->subject) && !is_null($this->options->subject)) {
      return $this->options->subject;
    }
    return NULL;
  }

  public function getHtmlBody() {
    $template = $this->options->template;
    $data = (array) $this->post;
    return Render::render($template, $data);
  }

  public function getAltBody() {
    if (property_exists($this->post, 'altbody')) {
      return $this->post->altbody;
    } else {
      return NULL;
    }
  }

}
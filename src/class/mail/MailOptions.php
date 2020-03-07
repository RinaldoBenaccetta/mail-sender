<?php


namespace Mail;


class MailOptions {

  const HOST = 'smtp.gmail.com';
  const PORT = 587;
  const ENCRYPTION = 'STARTTLS'; // STARTTLS or SMTPS
  const SMTP_AUTHENTICATION = TRUE;
  const MAIL_LOGIN = 'benaccettarinaldo@gmail.com';
  const MAIL_PASSWORD = 'vivelaneigeDejuin';
  const SENDER_MAIL = 'from@example.com';
  const SENDER_NAME = 'moi';
  const REPLY_MAIL = 'replyto@example.com';
  const REPLY_NAME = 'lui';
  const RECIPIENT_MAIL = 'rinaldobenaccetta@hotmail.com';
  const RECIPIENT_NAME = 'John Doe';

  public function __construct() {


  }

  public static function getHost() {
    return self::HOST;
  }

  public static function getPort() {
    return self::PORT;
  }

  public static function getEncryption() {
    return self::ENCRYPTION;
  }

  public static function getSmtpAuthentication() {
    return self::SMTP_AUTHENTICATION;
  }

  public static function getMailLogin() {
    return self::MAIL_LOGIN;
  }

  public static function getMailPassword() {
    return self::MAIL_PASSWORD;
  }

  public static function getSenderMAil() {
    return self::SENDER_MAIL;
  }

  public static function getSenderName() {
    return self::SENDER_NAME;
  }

  public static function getReplyMail() {
    return self::REPLY_MAIL;
  }

  public static function getReplyName() {
    return self::REPLY_NAME;
  }

  public static function getRecipientMail() {
    return self::RECIPIENT_MAIL;
  }

  public static function getRecipientName() {
    return self::RECIPIENT_NAME;
  }

  public function getAuthentication() {
    if (self::ENCRYPTION === 'STARTTLS') {
      return PHPMailer::ENCRYPTION_STARTTLS;
    } elseif (self::ENCRYPTION === 'SMTPS') {
      return PHPMailer::ENCRYPTION_SMTPS;
    }
  }
}
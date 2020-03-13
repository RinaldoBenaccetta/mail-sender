<?php


namespace MailSender\mail;

use MailSender\render\Render;


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
  const DEBUG = 'server'; // off | client | server
  const SUBJECT = 'un super sujet';
  const HTML_BODY = '<p style="color: green;">This is the HTML message body with text <b>in bold!</b></p>';
  const ALT_BODY = 'This is a plain-text message body';

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

  public static function getDebug() {
    return self::DEBUG;
  }

  public static function getSubject() {
    return self::SUBJECT;
  }

  public static function getHtmlBody() {
    return Render::render('contact-default.twig', [
      'contact' => [
        'firstName' => 'Toto',
        'name' => 'Le Héro',
        'phone' => '123 / 52 63 63'
      ],
      'message' => 'Hello!'
    ]);

    //return self::HTML_BODY;
  }

  public static function getAltBody() {
    return self::ALT_BODY;
  }

}
<?php


namespace MailSender\mail;


use MailSender\Tools\Tools;

/**
 * Class DefaultContact
 *
 * Transform provided POST data for the default contact E-mail.
 *
 * @package MailSender\mail
 */
class DefaultContact {

  const SUBJECT_PREFIX = "Demande d'information de la part de";
  const SUBJECT_SUFFIX = ".";


  /**
   * Return the subject builded with the subject's prefix and suffix
   * and with the post's prefix and suffix.
   * @param $post
   *
   * @return string
   */
  public static function getSubject($post) {
    $name = self::getName($post);
    return self::SUBJECT_PREFIX . " " . $name . self::SUBJECT_SUFFIX;
  }

  /**
   * Return the name builded with the post's firstname and name.
   *
   * @param $post
   *
   * @return string
   */
  public static function getName($post) {
    return Tools::buildName($post->senderFirstName, $post->senderName);
  }


}
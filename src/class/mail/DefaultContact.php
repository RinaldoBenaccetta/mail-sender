<?php


namespace MailSender\mail;


use MailSender\settings\GetSettings;
use MailSender\tools\Tools;

/**
 * Class DefaultContact
 *
 * Transform provided POST data for the default contact E-mail.
 *
 * @package MailSender\mail
 */
class DefaultContact {


  /**
   * Return the subject builded with the subject's prefix and suffix
   * and with the post's prefix and suffix.
   * @param $post
   *
   * @return string
   */
  public static function getSubject($post) {

    $prefix = GetSettings::getSettings()->defaultContactTemlate->subjectPrefix;
    $suffix = GetSettings::getSettings()->defaultContactTemlate->subjectSuffix;
    $name = self::getName($post);
    return $prefix . " " . $name . $suffix;
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
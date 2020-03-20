<?php


namespace MailSender\mail;


use MailSender\settings\GetConfig;
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

    $prefix = GetConfig::getSettings()->defaultContactTemlate->subjectPrefix;
    $suffix = GetConfig::getSettings()->defaultContactTemlate->subjectSuffix;
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
    if (!empty($post->senderFirstName))
    {
      $senderFirstName = $post->senderFirstName;
    } else {
      $senderFirstName = NULL;
    }

    if (!empty($post->senderName))
    {
      $senderName = $post->senderName;
    } else {
      $senderName = NULL;
    }

    return Tools::buildName($senderFirstName, $senderName);
  }

}
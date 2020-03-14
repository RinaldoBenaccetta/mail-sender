<?php


namespace MailSender\Tools;


class Tools {

  /**
   * Return a name from name and firstname provided.
   * Return null if the two arguments provided are null.
   * Return only name argument if firstname is null.
   * Return only firstname argument if name is null.
   *
   * @param $firstName
   * @param $name
   *
   * @return string
   */
  public static function buildName($firstName, $name) {
    $output = trim($firstName . ' ' . $name);
    return $output;
  }
}
<?php


namespace MailSender\tools;


class StringTool {

//  /**
//   * @param string $str
//   * @param string $sub
//   *
//   * @return bool
//   */
//  public static function endsWith( string $str, string $sub ) : bool {
//    return ( substr( $str, strlen( $str ) - strlen( $sub ) ) === $sub );
//  }

  public static function startsWith(string $haystack, string $needle) : bool
  {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
  }

  public static function endsWith(string $haystack, string $needle) : bool
  {
    $length = strlen($needle);
    if ($length == 0) {
      return true;
    }

    return (substr($haystack, -$length) === $needle);
  }

}
<?php


namespace MailSender\tools;


class StringTool
{

    /**
     * Check if a string start with an other string.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Check if a string end with an other string.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Transform HTML specials characters to ascii and escape the string.
     *
     * @param null $string
     * @return string|null
     */
    public static function toSanitizedString($string = null): ?string
    {
        if (!empty($string)) {
            return addslashes(htmlspecialchars((string)$string));
        }
        return null;

    }

}
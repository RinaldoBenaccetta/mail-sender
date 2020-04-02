<?php


namespace MailSender\tools;


class BoolTool
{
    /**
     * Transform provided value to boolean.
     * string 'true' become TRUE
     * string 'false' become FALSE
     * string '' become FALSE
     * int 1 become TRUE
     * int 0 become FALSE
     * null become FALSE
     *
     * @param $value
     * @return bool
     */
    public static function toBool($value): bool
    {
        return (bool)filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN
        );
    }

}
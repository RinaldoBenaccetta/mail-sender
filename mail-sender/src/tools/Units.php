<?php


namespace MailSender\tools;


class Units
{

    /**
     * @param     $bytes
     * @param int $precision
     *
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2)
    {
        $base = log($bytes, 1024);
        $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');

        return round(
                pow(1024, $base - floor($base)),
                $precision
            ) . ' ' . $suffixes[floor($base)];
    }
}
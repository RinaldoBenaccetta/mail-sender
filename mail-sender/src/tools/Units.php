<?php


namespace MailSender\tools;


class Units
{

    /**
     * @param $bytes
     * @param int $precision
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2)
    {
        $base = log($bytes, 1024);
        $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }



//    {
//        $units = array('B', 'KB', 'MB', 'GB', 'TB');
//
//        $bytes = max($bytes, 0);
//        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
//        $pow = min($pow, count($units) - 1);
//
//        // Uncomment one of the following alternatives
//        // $bytes /= pow(1024, $pow);
//        // $bytes /= (1 << (10 * $pow));
//
//        return round($bytes, $precision) . ' ' . $units[$pow];
//    }
}
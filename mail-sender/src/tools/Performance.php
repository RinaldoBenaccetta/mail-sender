<?php


namespace MailSender\tools;


class Performance
{
    public static function getAllocatedMemory($message = null): string
    {
        if (!empty($message)) {
            $message = strtoupper($message) . ' :: ';
        }
        $memoryUsage = Units::formatBytes(memory_get_usage(true));
        $memoryPeak = Units::formatBytes(memory_get_peak_usage(true));
        return "{$message}Alocated memory : {$memoryUsage} | Alocated memory Peak : {$memoryPeak}";
    }

    public static function getUsageMemory($message = null): string
    {
        if (!empty($message)) {
            $message = strtoupper($message) . ' :: ';
        }
        $memoryUsage = Units::formatBytes(memory_get_usage());
        $memoryPeak = Units::formatBytes(memory_get_peak_usage());
        return "{$message}Memory usage : {$memoryUsage} | Memory Peak : {$memoryPeak}";
    }

}
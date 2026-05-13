<?php

namespace App\Helpers;

class FormatHelper
{
    public static function rupiah($amount, $currency = 'Rp')
    {
        return $currency . ' ' . number_format((int)$amount, 0, ',', '.');
    }

    public static function date($date, $format = 'd M Y')
    {
        if (!$date) {
            return '-';
        }

        try {
            return \Carbon\Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return $date;
        }
    }

    public static function dateTime($dateTime, $format = 'd M Y H:i')
    {
        if (!$dateTime) {
            return '-';
        }

        try {
            return \Carbon\Carbon::parse($dateTime)->format($format);
        } catch (\Exception $e) {
            return $dateTime;
        }
    }
}

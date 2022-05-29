<?php
class FormatUtil
{
    public static function ISOChangeTimeZone($time, string $format = 'H:i:s d-m-Y')
    {
        $UTC = new DateTimeZone("UTC");
        $newTZ = new DateTimeZone("Asia/Ho_Chi_Minh");
        $date = new DateTime($time, $UTC);
        $date->setTimezone($newTZ);
        return $date->format($format);
    }

    public static function currencyVNDFormat($money)
    {
        return  number_format($money, 0, ',', '.') . ' ₫';
    }
}

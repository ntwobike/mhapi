<?php

namespace App\Util;

class DateTime
{
    const FORMAT_DEFAULT = 'Y-m-d H:i:s';

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param string $date
     * @param string $format
     *
     * @return string
     */
    public static function getDateTimeString($date = 'now', $format=self::FORMAT_DEFAULT): String
    {
        $date = new \DateTime($date, new \DateTimeZone("UTC"));

        return $date->format($format);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param string $date
     *
     * @return \DateTime
     */
    public static function getDateTime($date = 'now'): \DateTime
    {
        return new \DateTime($date, new \DateTimeZone("UTC"));
    }
}
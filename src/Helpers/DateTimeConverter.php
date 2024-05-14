<?php

namespace Astrogoat\CustomerExperience\Helpers;

use Carbon\Carbon;

class DateTimeConverter
{
    public static function utcToEst($time)
    {
        if (str_contains($time, ':') && substr_count($time, ':') == 1) {
            $time .= ':00';
        }

        $timestamp = date("Y-m-d") . ' ' . $time;
        $date = Carbon::createFromFormat("Y-m-d H:i:s", $timestamp, "UTC");

        return $date->setTimezone("America/New_York")->format('H:i:s');
    }

    public static function estToUtc($time)
    {
        if (str_contains($time, ':') && substr_count($time, ':') == 1) {
            $time .= ':00';
        }

        $timestamp = date("Y-m-d") . ' ' . $time;
        $date = Carbon::createFromFormat("Y-m-d H:i:s", $timestamp, "America/New_York");

        return $date->setTimezone("UTC")->format('H:i:s');
    }
}

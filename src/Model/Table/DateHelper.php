<?php

namespace App\Model\Table;

use Cake\I18n\Time;

class DateHelper
{
    public static function toDatabaseDateTimeString($timestampStringInMilliseconds) {
        $milliseconds = substr($timestampStringInMilliseconds, -3);
        $timestampInSeconds = substr($timestampStringInMilliseconds, 0, -3);
        $dateTimeText = Time::createFromTimestamp($timestampInSeconds)->toDateTimeString();
        return $dateTimeText.'.'.$milliseconds;
    }
}
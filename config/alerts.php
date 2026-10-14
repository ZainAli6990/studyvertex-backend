<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Study reminder time zone
    |--------------------------------------------------------------------------
    |
    | The "start / stop" times a user picks on the Profile screen (e.g.
    | 09:00 - 21:00) are wall-clock times. Users don't have a time zone of
    | their own yet, so they are read in this one. It only affects WHEN study
    | reminders are sent -- stored timestamps stay in the app time zone (UTC).
    |
    | Set ALERTS_TIMEZONE in .env to change it.
    |
    */

    'timezone' => env('ALERTS_TIMEZONE', 'Asia/Karachi'),

];

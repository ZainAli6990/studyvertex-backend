<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ALERTS -- study reminders and unfinished-quiz nudges are created on demand
// while the app is open (AlertService::refreshFor), so NOTHING here is
// required. These two lines only matter if you also run the Laravel
// scheduler (cron `schedule:run` in production, `schedule:work` locally) and
// want alerts prepared for people who haven't opened the app in a while.
Schedule::command('alerts:generate --only=study')->everyMinute()->withoutOverlapping();
Schedule::command('alerts:generate --only=quizzes')->everyTenMinutes()->withoutOverlapping();

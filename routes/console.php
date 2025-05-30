<?php

use App\Jobs\ProcessMatchPoints;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; 

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$schedule = app()->make(Schedule::class);

$schedule->job(new ProcessMatchPoints())
         ->cron('0 10-15,20-23,0-1 * * *');

$schedule->job(new ProcessMatchPoints())
         ->dailyAt('07:00');
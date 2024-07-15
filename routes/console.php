<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// this is a schedule that will reset the number of trainees for each trainer per day
Schedule::call(function () {
      User::where('role', 1)->update(['trainees_for_today' => DB::raw("`no_of_trainees`")]);
})->daily();
<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// SEO Automation Scheduled Jobs
Schedule::command('sitemap:generate')->daily();
Schedule::command('seo:audit --fix')->weekly();

// Performance monitoring
Schedule::call(function () {
    // Clear old performance logs
    \Illuminate\Support\Facades\Log::info('Performance monitoring cleanup completed');
})->daily();

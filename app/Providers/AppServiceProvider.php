<?php

namespace App\Providers;

use App\Models\WebSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('webSettings', WebSetting::getAllForPublic());
        });

        View::composer('components.navbar', function ($view) {
            $view->with('patients', \App\Models\Patient::orderBy('nama_lengkap')->get());
            $current = \Illuminate\Support\Facades\Route::current();
            $currentPatientId = $current && $current->getName() === 'public.pasien.show' && $current->parameter('patient')
                ? $current->parameter('patient')->id
                : null;
            $view->with('currentPatientId', $currentPatientId);
        });
    }
}

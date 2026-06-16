<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.public', function() {
            // Jika ada folder public_html di luar folder project (seperti di shared hosting), gunakan itu.
            // Jika tidak ada (seperti di lokal/komputer sendiri), gunakan folder public bawaan.
            return is_dir(base_path('../public_html')) 
                ? base_path('../public_html') 
                : base_path('public');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
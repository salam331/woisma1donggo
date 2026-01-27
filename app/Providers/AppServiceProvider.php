<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Macro untuk mengkonversi session success/error ke format toast
        Redirect::macro('withToast', function ($key, $value = null) {
            if (is_array($key)) {
                return $this->with('toast', $key);
            }
            return $this->with('toast', [
                'type' => $key,
                'message' => $value
            ]);
        });
    }
}

<?php

namespace eCreeth\LaravelResourceView;

use Illuminate\Support\ServiceProvider;
use eCreeth\LaravelResourceView\LaravelResourceView;

class ResourceViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            LaravelResourceView::class
        ]);
    }
}

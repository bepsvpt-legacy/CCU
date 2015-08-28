<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Filesystem $filesystem
     */
    public function boot(Filesystem $filesystem)
    {
        foreach ($filesystem->files(app_path('Libraries/Macros')) as $file)
        {
            $filesystem->requireOnce($file);
        }
        
        if ($this->app->environment(['local']))
        {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

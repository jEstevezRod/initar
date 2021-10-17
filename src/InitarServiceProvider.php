<?php

namespace Jestevezrod\Initar;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class InitarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/initar.php' => config_path('initar.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/initar'),
        ], 'public');

    }


}

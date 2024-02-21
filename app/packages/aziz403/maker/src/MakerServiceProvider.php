<?php

namespace Aziz403\Maker;

use Illuminate\Support\ServiceProvider;

class MakerServiceProvider extends ServiceProvider
{
    // boostrap web services
    // listen for events
    // publish configuration files or database migrations
    public function boot()
    {
        dd("its works");
    }

    // extern fonctionnality from other classes
    // registre service providers
    // create singleton classes
    public function register()
    {

    }
}
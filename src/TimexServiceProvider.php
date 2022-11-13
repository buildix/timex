<?php

namespace Buildix\Timex;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Buildix\Timex\Commands\TimexCommand;

class TimexServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('timex')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_timex_tables')
            ->hasCommand(TimexCommand::class);
    }
}

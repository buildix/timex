<?php

namespace Buildix\Timex;

use BladeUI\Icons\Factory;
use Buildix\Timex\Calendar\Day;
use Buildix\Timex\Calendar\Event;
use Buildix\Timex\Calendar\Month;
use Buildix\Timex\Calendar\Week;
use Filament\PluginServiceProvider;
use Illuminate\Contracts\Container\Container;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Buildix\Timex\Commands\TimexCommand;

class TimexServiceProvider extends PluginServiceProvider
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
            ->hasAssets()
            ->hasMigration('create_timex_tables');
    }

    public function boot()
    {
        Livewire::component('timex-month',Month::class);
        Livewire::component('timex-week',Week::class);
        Livewire::component('timex-day',Day::class);
        Livewire::component('timex-event',Event::class);

        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('timex', []);

            $factory->add('timex', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

        parent::boot();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/timex.php', 'timex');
    }

    protected function getPages(): array
    {
        return [
            \Buildix\Timex\Pages\Timex::class
        ];
    }
}
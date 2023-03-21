<?php

namespace Buildix\Timex;

use BladeUI\Icons\Factory;
use Buildix\Timex\Calendar\Day;
use Buildix\Timex\Calendar\Event;
use Buildix\Timex\Calendar\EventList;
use Buildix\Timex\Calendar\EventView;
use Buildix\Timex\Calendar\Header;
use Buildix\Timex\Calendar\Month;
use Buildix\Timex\Calendar\Week;
use Buildix\Timex\Commands\MakeAttachmentsTableCommand;
use Buildix\Timex\Commands\SetTableNameCommand;
use Buildix\Timex\Widgets\Mini\DayWidget;
use Buildix\Timex\Widgets\Mini\EventWidget;
use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\View\View;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Buildix\Timex\Commands\TimexCommand;

class TimexServiceProvider extends PluginServiceProvider
{
    protected array $scripts = [
      'timex' => __DIR__.'/../resources/dist/timex.js'
    ];

    protected array $styles = [
      'timex' => __DIR__.'/../resources/dist/timex.css'
    ];

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
            ->hasTranslations()
            ->hasMigration('create_timex_tables')
            ->hasCommands([
                MakeAttachmentsTableCommand::class
            ])
            ->hasInstallCommand(function (InstallCommand $command){
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('buildix/timex');
            });
    }

    public function boot()
    {
        Livewire::component('timex-month',Month::class);
        Livewire::component('timex-week',Week::class);
        Livewire::component('timex-day',Day::class);
        Livewire::component('timex-event',Event::class);
        Livewire::component('timex-event-widget',EventWidget::class);
        Livewire::component('timex-day-widget',DayWidget::class);
        Livewire::component('timex-event-list',EventList::class);
        Livewire::component('timex-header',Header::class);

        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('timex', []);

            $factory->add('timex', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

        if (config('timex.mini.isMiniCalendarEnabled')){
            Filament::registerRenderHook(
                'global-search.start',
                fn(): View => \view('timex::layout.heading')
            );
        }

        parent::boot();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/timex.php', 'timex');
    }

    protected function getPages(): array
    {
        return [
            config('timex.pages.timex')
        ];
    }
    protected function getResources(): array
    {
        return [
            config('timex.resources.event')
        ];
    }
}

<!-- TOC -->
  * [Installation](#installation)
  * [Publishing configuration](#publishing-configuration)
  * [Publishing translations](#publishing-translations)
<!-- TOC -->

## Install TiMEX as a filament plugin

TiMEX requires the following to run:
- PHP 8.0+
- Laravel v8.0+
- Livewire v2.0+
- Filament v2.0+

## Installation

Install TiMEX:

```bash
composer require buildix/timex
```

Once the package is downloaded to your environment, you can run the installation command, which will publish all necessary TiMEX assets:

```bash
php artisan timex:install
```
## Publishing configuration

If you wish, you may publish the configuration of the package using:

```bash
php artisan vendor:publish --tag=timex-config
```

## Publishing translations

If you wish to translate the package, you may publish the language files using:

```bash
php artisan vendor:publish --tag=timex-translations
```

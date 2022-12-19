<!-- TOC -->
* [#resources](##resources)
    * [event](#event-resource)
    * [sort](#sort)
    * [icon](#icon)
    * [slug](#slug)
    * [shouldRegisterNavigation](#shouldregisternavigation)
* [#models](##models)
    * [event](#event-model)
    * [users](#users)
* [#tables](##tables)
<!-- TOC -->
# TiMEX filament resource, laravel models & DB tables

## #resources
### event (resource)
Filament resource class (default: `\Buildix\EventResource::class`)
```php
'resources' => [
    'event' => \Buildix\Timex\Resources\EventResource::class,
],
```
You may create your own filament resource class & pages in order to list / manage your events. After creating your filament resource, make sure to register it in `timex.php` config

### sort
Integer (default: `1`)
```php
'resources' => [
    'sort' => 1,
],
```
Filament navigation item sorting

### icon
String (default: `heroicon-o-calendar`)
```php
'resources' => [
    'icon' => 'heroicon-o-calendar',
],
```
Filament navigation icon

### slug
String (default: `timex-events`)
```php
'resources' => [
    'slug' => 'timex-events',
],
```
Slug is used to define the url of your resource page

### shouldRegisterNavigation
Boolean (default: `true`)
```php
'resources' => [
    'shouldRegisterNavigation' => true,
],
```
If it's `true`, TiMEX filament resource will be registered on your navigation panel

If [enablePolicy](03-page.md) is set to `true` option `shouldRegisterNavigation` will be ignored and access to TiMEX filament resource will be configured in accordance with your laravel policies made for TiMEX event model

### isStartEndHidden
Boolean (default: `false`)
```php
'resources' => [
    'isStartEndHidden' => false,
],
```

If it's `true`, startTime & endTime DateTimePickers would be hidden from create & edit forms. Labels for times would be also hidden from the calendar view

## #models
### event (model)
Laravel model (default: `\Buildix\Event::class`)
```php
'models' => [
    'event' => \Buildix\Timex\Models\Event::class,
],
```
You may create your own laravel model to store your events. After creating your laravel model, make sure to register it in `timex.php` config
### users
Laravel model (default: `\App\Models\User::class`)
```php
'models' => [
    'users' => [
        'model' => \App\Models\User::class,
        'name' => 'name',
        'id' => 'id',
    ],
],
```

## #tables
### event (#name)
String (default: `timex_events`)
```php
'tables' => [
    'event' => [
        'name' => 'timex_events',
    ],
],
```
Name of your DB table to store TiMEX events. You may change to any other name that fits your application.
### category (#name)
String (default: `timex_categories`)
```php
'tables' => [
    'category' => [
        'name' => 'timex_categories',
    ],
],
```
Name of your DB table to store TiMEX categories. You may change to any other name that fits your application.

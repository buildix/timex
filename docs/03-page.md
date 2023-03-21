# #pages
## timex
Filament page class (default: `\Buildix\Timex\Pages\Timex::class`)
```php
'pages' => [
    'timex' => \Buildix\Timex\Pages\Timex::class,
```
You may create your own filament page and extend `Buildix\Timex::class`
All available methods on the parent page, you can override on your created page

## slug
String (default: `timex`)
```php
'pages' => [
    'slug' => 'timex',
```
Slug is used to define the url of your calendar page

## group
String (default: `timex`)
```php
'pages' => [
    'group' => 'timex',
```
Group defines filament navigation group item. You may change it to whatever you want in order to group your navigation items as you wish

## sort
Integer (default: `0`)
```php
'pages' => [
    'sort' => 0,
```
Filament group navigation sorting

## shouldRegisterNavigation
Boolean (default: `true`)
```php
'pages' => [
    'shouldRegisterNavigation' => true,
```
If it's `true`, TiMEX page & TiMEX filament resource will be registered on your navigation panel

## enablePolicy
Boolean (default: `false`)
```php
'pages' => [
    'enablePolicy' => false,
```
If it's `true`, option `shouldRegisterNavigation` will be ignored and access to TiMEX page & TiMEX filament resource will be configured in accordance with your laravel policies made for TiMEX event model 

## modalWidth
String (default: `xl`)
```php
'pages' => [
    'modalWidth' => 'xl',
```
You may change the width of event creation / edit & view on the TiMEX page from `xs` - `7xl`

## icon (#static)
Boolean (default: `true`)
```php
'pages' => [
    'icon' => [
        'static' => true,
    ],
```
If it's `true`, default TiMEX icon will be used on the navigation panel, if it's `false`, dynamic icon for the day will be used instead

## icon (#timex)
String (default: `timex-timex`)
```php
'pages' => [
    'icon' => [
        'timex' => 'timex-timex',
    ],
```
Default TiMEX icon, you may change it to any other installed icon packages for the static icon on your navigation panel

## label (#navigation > #static)
Boolean (default: `false`)
```php
'pages' => [
    'label' => [
        'navigation' => [
            'static' => false,
        ],
```
If it's `true`, the navigation label will be changed from current day label to static stated in `lang/timex.php`

## label (#navigation > #format)
Carbon formatter (default: `dddd, D MMM`)
```php
'pages' => [
    'label' => [
        'navigation' => [
            'format' => 'dddd, D MMM',
        ],
```
You may change how the navigation label displayed in accordance with Carbon formats

**Same applied for breadcrumbs & page title**

<!-- TOC -->
* [#categories](##categories)
    * [isModelEnabled](#ismodelenabled)
    * [model](#model)
    * [TiMEX categories](#timex-categories)
<!-- TOC -->
# Categories

## isModelEnabled
Boolean (default: `false`)
```php
'categories' => [
    'isModelEnabled' => false,
```
If it's true, Laravel model will be used for TiMEX event categories

## model
Laravel model class (default: `\Buildix\Category::class`)
```php
'categories' => [
    'model' => [
        'class' => \Buildix\Timex\Models\Category::class,
        'key' => 'id',
        'value' => 'value',
        'icon' => 'icon',
        'color' => 'color',
```
## TiMEX categories
```php
'categories' => [
    'labels' => [
        'primary' => 'Primary category',
        'secondary' => 'Secondary category',
        'danger' => 'Danger category',
        'success' => 'Success category',
    ],
    'icons' => [
        'primary' => 'heroicon-o-clipboard',
        'secondary' => 'heroicon-o-bookmark',
        'danger' => 'heroicon-o-flag',
        'success' => 'heroicon-o-badge-check',
    ],
    'colors' => [
        'primary' => 'primary',
        'secondary' => 'secondary',
        'danger' => 'danger',
        'success' => 'success',
    ],
],
```

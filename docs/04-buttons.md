# #buttons

## hideYearNavigation
Boolean (default: `false`)
```php
'pages' => [
    'buttons' => [
        'hideYearNavigation' => false,
```
If it's true, buttons to jump to next / previous year (with current month) will be hidden in navigation bar of TiMEX page

## today (#static)
Boolean (default: `false`)
```php
'pages' => [
    'buttons' => [
        'today' => [
            'static' => false,
        ],
```
If it's true, label for current day will be static in accordance with `lang/timex.php`

## today (#format)
Carbon formatter (default: `D MMM`)
```php
'pages' => [
    'buttons' => [
        'today' => [
            'format' => 'D MMM'
        ],
```
You may change how the button label displayed in accordance with Carbon formats

## outlined
Boolean (default: `true`)
```php
'pages' => [
    'buttons' => [
        'outlined' => true,
```
You may change how the buttons in navigation panel of TiMEX page are styled (outlined / filled)

## icons
Default TiMEX icon set for buttons:
  - previousYear: `heroicon-o-chevron-double-left`
  - nextYear: `heroicon-o-chevron-double-right`
  - previousMonth: `heroicon-o-chevron-left`
  - nextMonth: `heroicon-o-chevron-right`
  - createEvent: `heroicon-o-plus`
```php
'pages' => [
    'icons' => [
        'previousYear' => 'heroicon-o-chevron-double-left',
        'nextYear' => 'heroicon-o-chevron-double-right',
        'previousMonth' => 'heroicon-o-chevron-left',
        'nextMonth' => 'heroicon-o-chevron-right',
        'createEvent' => 'heroicon-o-plus'
    ],
```
## modal
#submit / #cancel / #delete / #edit

### **#outlined**
Boolean (default: `true`)
```php
'pages' => [
    'buttons' => [
        'modal' => [
            'submit' => [
                'outlined' => false,
            ],
```
You may change how the buttons in navigation panel of TiMEX page are styled (outlined / filled)

### **#color**

`primary` / `secondary` / `danger` / `primary` / 
```php
'pages' => [
    'buttons' => [
        'modal' => [
            'submit' => [
                'color' => 'primary',
            ],
```
### **#icon**

**enabled**

Boolean (default: `true`)
  ```php
  'pages' => [
      'buttons' => [
          'modal' => [
              'submit' => [
                  'icon' => [
                      'enabled' => true,
              ],
          ],
  ```
**#name**

Any icon package you have installed
  ```php
  'pages' => [
      'buttons' => [
          'modal' => [
              'submit' => [
                  'icon' => [
                      'name' => 'heroicon-o-save'
          ],
      ],
  ```

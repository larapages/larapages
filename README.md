# LaraPages
A simple CMS build on Laravel 5 (requires 5.1 or higher).
Basically it's a webbased editor for your Laravel models. Each model must have a `$pagesAdmin` array. See the samples folder for an example. A basic media/filemanager is included too.

## Installation
To install package use  
`composer require nickdekruijk/larapages`  
or  
`composer require nickdekruijk/larapages:dev-master`  
  
Add the Service Provider to the `'providers'` array in `config/app.php`  
```php
NickDeKruijk\LaraPages\LaraPagesServiceProvider::class,
```

Add the larapages middleware to the `$routeMiddleware` array in `app/Http/Kernel.php`
```php
'larapages' => \NickDeKruijk\LaraPages\LaraPagesAuth::class,
```

Publish the css/js/config with  
`php artisan vendor:publish` the first time or `php artisan vendor:publish --tag=public --force --provider="NickDeKruijk\LaraPages\LaraPagesServiceProvider"` after a `composer update`.

## Configuration
After installation (if you did `php artisan vendor:publish`) a default config file called `larapages.php` will be available in your Laravel `app/config` folder.

## Frontend
To get you started an example model and migration is provided in the samples folder.
To use the Frontend template and to parse the pages add this to your `routes.php` (Laravel 5.2 and earlier) or `web.php` (Laravel 5.3 or later) if you use the Page model from our sample
```php
Route::get('{any}', '\App\Page@route')->where('any', '(.*)');
```
Feel free to copy the templates to your Laravel `resources/views/vendor/larapages/main` folder and edit them as you like. Or create your own views and set them in the config file.

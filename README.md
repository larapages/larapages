# LaraPages
A simple CMS build on Laravel 5 (requires 5.1 or higher)

## Installation
To install package use
```composer require nickdekruijk/larapages```
or
```composer require nickdekruijk/larapages:dev-master```
<br>
Add the Service Provider to the `'providers'` array in `config/app.php`<br>
```NickDeKruijk\LaraPages\LaraPagesServiceProvider::class,```
<br>
If you haven't done so already activate authentication with either<br>
```php artisan make:auth```
or adding this to `app/routes.php`<br>
```Route::group(['middleware' => ['web']], function () {
    Route::auth();
});
```
Add the following to `app/Http/Controllers/Auth/AuthController`
```
    /**
     * Custom larapages login form
     */
    public function showLoginForm()
    {
        return view('laraPages::login');
    }
```
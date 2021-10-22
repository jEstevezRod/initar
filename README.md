<p align="center"><img src="/art/initar.png" alt="Social Card of Laravel Activity Log"></p>

# Laravel Initar

[![Latest Stable Version](http://poser.pugx.org/jestevezrod/initar/v)](https://packagist.org/packages/jestevezrod/initar)
[![Total Downloads](http://poser.pugx.org/jestevezrod/initar/downloads)](https://packagist.org/packages/jestevezrod/initar)
[![Latest Unstable Version](http://poser.pugx.org/jestevezrod/initar/v/unstable)](https://packagist.org/packages/jestevezrod/initar)
[![License](http://poser.pugx.org/jestevezrod/initar/license)](https://packagist.org/packages/jestevezrod/initar) [![PHP Version Require](http://poser.pugx.org/jestevezrod/initar/require/php)](https://packagist.org/packages/jestevezrod/initar)

## Installation

```
composer require jestevezrod/initar
```

## What it does?
This package allows you to create and assign in a very easy way the default avatar profile for your users using their name and lastname initials.

## Configuration
Once installed you have to add the trait to your User model:

```php
use \Jestevezrod\Initar\Traits\HasInitar;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasInitar;

```

If for some reason you don't have the initar.php config file, you can create it running:

```
php artisan vendor:publish
```

You should modify the config file to make the package works as you desire. For instance you can add a list of colors to be used as background color of the avatar.


<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Laravel packages
   |--------------------------------------------------------------------------
   |
   | This file store a list of laravel packages acacha/llum can install.
   |
   */

    'AdminLTE' => [
        'name' => 'acacha/admin-lte-template-laravel',
        'providers' => ['Barryvdh\Debugbar\ServiceProvider::class'],
        'aliases' => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
    ],

    'LaravelDebugbar' => [
        'name' => 'barryvdh/laravel-debugbar',
        'providers' => ['Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class'],
        'aliases' => ['Debugbar' => 'Barryvdh\Debugbar\Facade::class'],
        'after' => 'php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"',
    ],

    'LaravelIdeHelper' => [
        'name' => 'barryvdh/laravel-ide-helper',
        'providers' => ['Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class'],
        'aliases' => [''],
        'after' => 'php artisan ide-helper:generate',
    ],

    'Socialite' => [
        'name' => 'laravel/socialite',
        'providers' => ['Laravel\Socialite\SocialiteServiceProvider::class'],
        'aliases' => ['Socialite' => 'Laravel\Socialite\Facades\Socialite::class'],
    ],

];

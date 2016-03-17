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
        'providers' => ['Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class'],
        'aliases' => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
        'after' => 'php artisan vendor:publish --tag=adminlte --force',
    ],

    'LaravelDebugbar' => [
        'name' => 'barryvdh/laravel-debugbar',
        'providers' => ['Barryvdh\Debugbar\ServiceProvider::class'],
        'aliases' => ['Debugbar' => 'Barryvdh\Debugbar\Facade::class'],
        'after' => 'php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"',
    ],

    'LaravelIdeHelper' => [
        'name' => 'barryvdh/laravel-ide-helper',
        'providers' => ['Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class'],
        'after' => 'php artisan ide-helper:generate',
    ],

    'Socialite' => [
        'name' => 'laravel/socialite',
        'providers' => ['Laravel\Socialite\SocialiteServiceProvider::class'],
        'aliases' => ['Socialite' => 'Laravel\Socialite\Facades\Socialite::class'],
    ],

    'AcachaSocialite' => [
        'name' => 'acacha/acacha-socialite',
        'providers' => ['Acacha\Socialite\Providers\AcachaSocialiteServiceProvider::class'],
        'after' => 'php artisan vendor:publish --tag=acachasocialite --force',
    ],

];

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

    // PD: Laravel 5.5 Package discovery
    'AdminLTEPD' => [
        'name'      => 'acacha/admin-lte-template-laravel',
        'after'     => 'php artisan adminlte-laravel:publish --force',
    ],

    'AdminLTE' => [
        'name'      => 'acacha/admin-lte-template-laravel',
        'providers' => ['Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class'],
        'aliases'   => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
        'after'     => 'php artisan adminlte-laravel:publish --force',
    ],

    'AdminLTEDontForce' => [
        'name'      => 'acacha/admin-lte-template-laravel',
        'providers' => ['Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class'],
        'aliases'   => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
        'after'     => 'php artisan adminlte-laravel:publish',
        'aliases'   => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
        'after'     => 'php artisan adminlte-laravel:publish',
    ],

    'AdminLTEVendorPublish' => [
        'name'      => 'acacha/admin-lte-template-laravel',
        'providers' => ['Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class'],
        'aliases'   => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
        'after'     => 'php artisan vendor:publish --tag=adminlte --force',
    ],

    'AdminLTEVendorPublishDontForce' => [
        'name'      => 'acacha/admin-lte-template-laravel',
        'providers' => ['Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class'],
        'aliases'   => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
        'after'     => 'php artisan vendor:publish --tag=adminlte',
    ],

    'LaravelDebugbar' => [
        'name'      => 'barryvdh/laravel-debugbar',
        'providers' => ['Barryvdh\Debugbar\ServiceProvider::class'],
        'aliases'   => ['Debugbar' => 'Barryvdh\Debugbar\Facade::class'],
        'after'     => 'php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"',
    ],

    'LaravelIdeHelper' => [
        'name'      => 'barryvdh/laravel-ide-helper',
        'providers' => ['Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class'],
        'after'     => 'php artisan ide-helper:generate',
    ],

    'Socialite' => [
        'name'      => 'laravel/socialite',
        'providers' => ['Laravel\Socialite\SocialiteServiceProvider::class'],
        'aliases'   => ['Socialite' => 'Laravel\Socialite\Facades\Socialite::class'],
    ],

    'LaravelPassport' => [
        'name'      => 'laravel/passport',
        'providers' => ['Laravel\Passport\PassportServiceProvider::class'],
        'after'     => 'php artisan migrate;php artisan passport:install',
    ],

    'Passport' => [
        'name'      => 'laravel/passport',
        'providers' => ['Laravel\Passport\PassportServiceProvider::class'],
        'after'     => 'php artisan migrate;php artisan passport:install',
    ],

    'Menu' => [
        'name'      => 'spatie/laravel-menu',
        'providers' => ['Spatie\Menu\Laravel\MenuServiceProvider::class'],
        'aliases'   => [
            'Menu' => 'Spatie\Menu\Laravel\MenuFacade::class',
            'Link' => 'Spatie\Menu\Laravel\Link::class',
            'Html' => 'Spatie\Menu\Laravel\Html::class'
        ]
    ],

    'laravel-menu' => [
        'name'      => 'spatie/laravel-menu',
        'providers' => ['Spatie\Menu\Laravel\MenuServiceProvider::class'],
        'aliases'   => [
            'Menu' => 'Spatie\Menu\Laravel\MenuFacade::class',
            'Link' => 'Spatie\Menu\Laravel\Link::class',
            'Html' => 'Spatie\Menu\Laravel\Html::class'
        ]
    ],

    'l5-repository' => [
        'name'      => 'prettus/l5-repository',
        'providers' => ['Prettus\Repository\Providers\RepositoryServiceProvider::class']
    ],

    'acacha-l5-repository' => [
        'name'      => 'acacha/l5-repository',
        'providers' => ['Prettus\Repository\Providers\RepositoryServiceProvider::class']
    ],

    'laravel-social' => [
        'name'      => 'acacha/laravel-social',
        'providers' => ['Acacha\LaravelSocial\Providers\LaravelSocialServiceProvider::class'],
        'after'     => 'php artisan make:social',
    ],

    'LaravelSocial' => [
        'name'      => 'acacha/laravel-social',
        'providers' => ['Acacha\LaravelSocial\Providers\LaravelSocialServiceProvider::class'],
        'after'     => 'php artisan make:social',
    ],
];

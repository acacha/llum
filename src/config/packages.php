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

    'Socialite' => [
        'name'      => 'laravel/socialite',
        'providers' => ['Laravel\Socialite\Facades\Socialite::class'],
        'aliases'   => ['Socialite' => 'Laravel\Socialite\Facades\Socialite::class'],
    ],

    'AdminLTE' => [
        'name'      => 'acacha/admin-lte-template-laravel',
        'providers' => ['Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class'],
        'aliases'   => ['AdminLTE' => 'Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class'],
    ],
];
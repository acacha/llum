#!/usr/bin/env bash
rm -rf config
rm -rf database
rm -rf .env
composer remove barryvdh/laravel-ide-helper
composer remove barryvdh/laravel-debugbar
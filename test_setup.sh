#!/usr/bin/env bash

function downloadLaravelConfigAppFile(){
    wget --quiet -O config/app.php https://raw.githubusercontent.com/laravel/laravel/master/config/app.php
}

function downloadLaravelEnvFile(){
    wget --quiet -O .env https://raw.githubusercontent.com/laravel/laravel/master/.env.example
}

mkdir -p config
mkdir -p database
downloadLaravelConfigAppFile
downloadLaravelEnvFile






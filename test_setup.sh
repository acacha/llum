#!/usr/bin/env bash

function downloadLaravelConfigAppFile(){
    wget --quiet -O config/app.php https://raw.githubusercontent.com/laravel/laravel/master/config/app.php
}

mkdir -p config
downloadLaravelConfigAppFile






#!/usr/bin/env bash

. ./src/bash_scripts/llum.sh

function downloadLaravelConfigAppFile(){
    wget --quiet -O config/app.php https://raw.githubusercontent.com/laravel/laravel/master/config/app.php
}

mkdir -p config
downloadLaravelConfigAppFile
iluminar "config/app.php"
cat config/app.php
rm -rf config






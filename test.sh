#!/usr/bin/env bash

. ./src/bash_scripts/llum.sh

./test_setup.sh
iluminar "config/app.php" "config/services.php"
cat config/app.php
./test_teardown.sh


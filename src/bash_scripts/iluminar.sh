#!/usr/bin/env bash

if [[ -z "$1" ]]; then
    echo "No file specified! Use: iluminar {PATH_TO_LARAVEL_CONFIG_FILE}. For example iluminar config/app.php"
    exit 1
fi

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

. ${DIR}/llum.sh


iluminar $1

iluminarServices $2
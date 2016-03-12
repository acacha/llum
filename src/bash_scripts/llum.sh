#!/usr/bin/env bash

TEXT_TO_INSERT_TO_PROVIDERS="        /*\n\         * Acacha Llum Service Providers...\n         *\n         * See: https://github.com/acacha/llum\n         */\n        #llum_providers\n"
TEXT_TO_INSERT_TO_ALIASES="        /*\n\         * Acacha Llum Aliases...\n         *\n         * See: https://github.com/acacha/llum\n         */\n        #llum_aliases\n"

function searchLineToInsertNewValueToEndOfPHPArray()
{
    local line=$(sed -n "/'$1'/=" $2);
    nline=$(sed -n ${line},\$p $2 | sed -n "/]/{=;q};");
    echo "$(($line + $nline -1))"
}

function insertLineIntoFile(){
    sed -i "$2i\\$3" "$1"
}

function abortIfLlumIsAlreadyInstalled(){
    if grep -Fq "#llum_providers" $1
    then
        echo "Llum is already installed. Exiting...";
        exit
    fi
}

function abortIfFileDoesNotExists(){
    if [ ! -f $1 ]; then
        echo "File $1 not found!"
        exit 1;
    fi
}

function iluminar(){
    abortIfFileDoesNotExists "$1";
    abortIfLlumIsAlreadyInstalled "$1";
    line=$(searchLineToInsertNewValueToEndOfPHPArray 'providers' "$1")
    insertLineIntoFile "$1" "$line" "$TEXT_TO_INSERT_TO_PROVIDERS"
    line=$(searchLineToInsertNewValueToEndOfPHPArray 'aliases' "$1")
    insertLineIntoFile "$1" "$line" "$TEXT_TO_INSERT_TO_ALIASES"
    echo "File $1 updated correctly" ;
    exit 0;
}
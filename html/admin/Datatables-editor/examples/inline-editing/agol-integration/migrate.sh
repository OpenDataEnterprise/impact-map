#!/bin/bash

export AGOL_USER=ODEnterprise
export AGOL_PASS=1mpactm@p

if [ "$1" != "" ]; then
    export AGOL_ENV=$1
else
    export AGOL_ENV=development
fi

python agol_integration.py

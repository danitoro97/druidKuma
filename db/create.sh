#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE druidkuma_test;"
    psql -U postgres -c "CREATE USER druidkuma PASSWORD 'druidkuma' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists druidkuma
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists druidkuma_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists druidkuma
    sudo -u postgres psql -c "CREATE USER druidkuma PASSWORD 'druidkuma' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O druidkuma druidkuma
    sudo -u postgres createdb -O druidkuma druidkuma_test
    LINE="localhost:5432:*:druidkuma:druidkuma"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi

#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U druidkuma -d druidkuma < $BASE_DIR/druidkuma.sql
fi
psql -h localhost -U druidkuma -d druidkuma_test < $BASE_DIR/druidkuma.sql

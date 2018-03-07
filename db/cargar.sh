#!/bin/sh


BASE_DIR=$(dirname $(readlink -f "$0"))
psql -h localhost -U druidkuma -d druidkuma < $BASE_DIR/$1

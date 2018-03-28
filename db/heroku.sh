#!/bin/bash

heroku psql < druidkuma.sql
heroku psql < ligas.sql
heroku psql < equipos.sql
heroku psql < jugadores.sql
heroku psql < partidos.sql
heroku psql < noticias.sql

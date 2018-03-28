------------------------------
-- Archivo de base de datos --
------------------------------
--TABLA PAISES

DROP TABLE IF EXISTS paises CASCADE;
CREATE TABLE paises
(
     id bigserial PRIMARY KEY
    ,nombre varchar(255) not null unique

);

--INSERT PAISES --
INSERT INTO paises(nombre)
VALUES('ESPAÑA'),('INGLATERRA'),('ALEMANIA'),('ITALIA');

--TABLA LIGAS--

DROP TABLE IF EXISTS ligas CASCADE;
CREATE TABLE ligas(
        id bigserial PRIMARY KEY
    ,   nombre varchar(255) not null unique
    ,   pais_id bigint not null references paises(id)
                        ON DELETE NO ACTION
                        ON UPDATE CASCADE
    ,   siglas varchar(255)


);

--TABLA EQUIPOS--
DROP TABLE IF EXISTS equipos CASCADE;

CREATE TABLE equipos (
        id bigserial primary KEY
    ,   nombre varchar(255) not null
    ,   alias varchar(255)
    ,   liga_id bigint not null references ligas (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
    ,   url                 varchar(255)
    ,   Unique (nombre,liga_id)
);

--TABLA POSICIONES--
DROP TABLE IF EXISTS posiciones CASCADE;
CREATE TABLE posiciones
(
        id bigserial primary KEY
    ,   nombre varchar(255) not null UNIQUE
    ,   siglas varchar(10)
);

--INSERT POSICIONES--
INSERT INTO posiciones (id,nombre,siglas)
VALUES   (0,'PORTERO','PT'),
         (1,'DEFENSA','DF'),
         (2,'MEDIOCENTRO','MD'),
         (3,'DELANTERO CENTRO','DC');

--TABLA JUGADORES
DROP TABLE IF EXISTS jugadores CASCADE;
CREATE TABLE jugadores
(
        id bigserial primary KEY
    ,   nombre varchar(255)   not NULL
    ,   posicion_id bigint not null references posiciones (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
    ,   dorsal numeric(5)
    ,   contrato VARCHAR(255)
    ,   equipo_id bigint not null references equipos(id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
);

--TABLA PARTIDOS--
DROP TABLE IF EXISTS partidos CASCADE;
CREATE TABLE partidos
(
     id bigserial primary KEY
    ,fecha date
    ,local_id bigint not null references equipos(id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
    ,visitante_id bigint not null references equipos(id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
    ,liga_id bigint not null references ligas(id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
    ,estado VARCHAR(255)
    ,goles_local numeric(3)
    ,goles_visitante numeric(3)
);

--TABLA ROLES --
DROP TABLE IF EXISTS roles CASCADE;

CREATE TABLE roles
(
        id BIGSERIAL PRIMARY KEY
    ,   nombre VARCHAR(255) NOT NULL UNIQUE
);

--Insert roles --
INSERT INTO roles (nombre)
VALUES ('estandar'),
        ('creador');

--TABLA USUARIOS --

DROP TABLE IF EXISTS usuarios_id CASCADE;
CREATE TABLE usuarios_id
(
        id  BIGSERIAL PRIMARY KEY
);
INSERT INTO usuarios_id(id)
VALUES(default),(default);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
         id        bigint       PRIMARY KEY REFERENCES usuarios_id (id)
    ,   nombre     VARCHAR(255) NOT NULL UNIQUE
    ,   email      VARCHAR(255) NOT NULL UNIQUE
    ,   password   VARCHAR(255) NOT NULL
    ,   auth_key   VARCHAR(255) UNIQUE
    ,   token_val  VARCHAR(255) UNIQUE
    ,   role_id    BIGINT NOT NULL DEFAULT 1 REFERENCES roles(id)
                    ON DELETE NO ACTION
                    ON UPDATE CASCADE
    ,   created_at TIMESTAMP(0)
    ,   updated_at TIMESTAMP(0)

);

--INSERT USUARIOS --

INSERT INTO usuarios (id,nombre,email,password,created_at,role_id)
    VALUES (1,'toro','danitoni2008@gmail.com',crypt('toro',gen_salt('bf','13')),'2018-03-06',2),
            (2,'pepe','pepe@gmail.com',crypt('toro',gen_salt('bf','13')),'2018-03-06',1);

--TABLA NOTICIAS --

DROP TABLE IF EXISTS noticias CASCADE;

CREATE TABLE noticias (
        id BIGSERIAL PRIMARY KEY
    ,   titulo VARCHAR(255) NOT NULL
    ,   subtitulo VARCHAR(255)
    ,   texto TEXT NOT NULL
    ,   img     VARCHAR(255)
    ,   creador_id BIGINT NOT NULL REFERENCES usuarios_id(id)
                    ON DELETE NO ACTION
                    ON UPDATE CASCADE
    ,   created_at TIMESTAMP(0)
    ,   updated_at TIMESTAMP(0)
);

--Insert noticias , es un fichero aparte--

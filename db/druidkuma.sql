------------------------------
-- Archivo de base de datos --
------------------------------

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

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
        id         BIGSERIAL    PRIMARY KEY
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
    ,   soft_delete boolean  default false
);

--INSERT USUARIOS --

INSERT INTO usuarios (nombre,email,password,created_at,role_id)
    VALUES ('toro','danitoni2008@gmail.com',crypt('toro',gen_salt('bf','13')),'2018-03-06',2),
            ('pepe','pepe@gmail.com',crypt('toro',gen_salt('bf','13')),'2018-03-06',1);

--TABLA NOTICIAS --

DROP TABLE IF EXISTS noticias CASCADE;

CREATE TABLE noticias (
        id BIGSERIAL PRIMARY KEY
    ,   titulo VARCHAR(255) NOT NULL
    ,   subtitulo VARCHAR(255)
    ,   texto TEXT NOT NULL
    ,   img     VARCHAR(255)
    ,   creador_id BIGINT NOT NULL REFERENCES usuarios(id)
                    ON DELETE NO ACTION
                    ON UPDATE CASCADE
    ,   created_at TIMESTAMP(0)
    ,   updated_at TIMESTAMP(0)
);

--Insert noticias , es un fichero aparte--

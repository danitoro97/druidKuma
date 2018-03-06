------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
        id         BIGSERIAL    PRIMARY KEY
    ,   nombre     VARCHAR(255) NOT NULL UNIQUE
    ,   email      VARCHAR(255) NOT NULL UNIQUE
    ,   password   VARCHAR(255) NOT NULL
    ,   auth_key   VARCHAR(255)
    ,   token_val  VARCHAR(255) UNIQUE
    ,   created_at TIMESTAMP(0) NOT NULL
);

--INSERT USUARIOS --

INSERT INTO usuarios (nombre,email,password,created_at)
    VALUES ('toro','danitoni2008@gmail.com',crypt('toro',gen_salt('bf','13')),'2018-03-06');

--Create noticias --

DROP TABLE IF EXISTS noticias CASCADE;

CREATE TABLE noticias (
        id BIGSERIAL PRIMARY KEY
    ,   titulo VARCHAR(255) NOT NULL
    ,   texto TEXT NOT NULL
    ,   img     VARCHAR(255)
    ,   created_at TIMESTAMP(0) NOT NULL
);

--Insert noticias --
INSERT INTO noticias (titulo,texto,img,created_at)
    VALUES ('Prueba', 'esto es mi primera prueba', 'https://www.dropbox.com/s/oeqfye2gh9pmhdu/descarga.png?dl=1', '2018-03-06');

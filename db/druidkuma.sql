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
    ,   url      varchar(255)
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

--TABLA DEtalles_PARTIDOS --
DROP TABLE IF EXISTS detalles_partidos CASCADE;
CREATE TABLE detalles_partidos
(
        id bigserial primary key
        , partido_id bigint not null references partidos(id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
        , equipo_id bigint not null references equipos (id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
        , minuto varchar(255) not null
        , jugador_id bigint not null references jugadores(id)
                            ON DELETE NO ACTION
                            ON UPDATE CASCADE
        , roja boolean default false
        , amarilla boolean default false
        , gol boolean default false
        , autogol boolean default false
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

--Comentarios----
DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios
(
         id bigserial primary KEY
        , comentario text
        , noticia_id BIGINT REFERENCES noticias(id)
                        ON DELETE NO ACTION
                        ON UPDATE CASCADE
        , usuario_id BIGINT NOT NULL REFERENCES usuarios_id(id)
                        ON DELETE NO ACTION
                        ON UPDATE CASCADE
        , padre_id BIGINT REFERENCES comentarios(id)
                        ON DELETE NO ACTION
                        ON UPDATE CASCADE
        , created_at TIMESTAMP(0)
        , updated_at TIMESTAMP(0)
);

--Create tabla equipos_usuarios --

DROP TABLE IF EXISTS equipos_usuarios CASCADE;
CREATE TABLE equipos_usuarios
(
         id bigserial primary key
        ,nombre varchar(255) UNIQUE
        ,creador_id bigint not null references usuarios(id)
                    on delete cascade
                    on update cascade
        ,created_at TIMESTAMP(0)
        ,updated_at TIMESTAMP(0)
);
--el creador es el que manda si se borra el equipo se borra los participantes--
--Inser equipos_usuarios---
INSERT INTO equipos_usuarios (nombre,creador_id)
VALUES ('pRUEBA EQUIPO',1);

--Create tabla participantes---

DROP TABLE IF EXISTS participantes CASCADE;
CREATE TABLE participantes
(
    equipo_id bigint references equipos_usuarios(id)
                    on delete cascade
                    on update CASCADE
    ,usuario_id bigint references usuarios(id)
                        on delete cascade
                        on update CASCADE
    ,aceptar bool default false
    ,CONSTRAINT pk_equipo_usuario primary key(equipo_id,usuario_id)
);

--insert participantes --
INSERT INTO participantes (equipo_id,usuario_id,aceptar)
values (1,1,true),(1,2,false);

--CREAR TABLA POSTS
DROP TABLE IF EXISTS posts CASCADE;
CREATE TABLE posts
(
         id bigserial primary key
        ,creador_id bigint not null references usuarios_id(id)
                            on delete no action
                            on update cascade
        ,equipo_usuario_id bigint references equipos_usuarios(id)
                            on delete cascade
                            on update cascade
        ,titulo  varchar(255)
        ,texto text
        ,created_at TIMESTAMP(0)
        ,updated_at TIMESTAMP(0)
        ,img varchar(255)
        CONSTRAINT  ck_null_text_img CHECK (texto is not null or img is not null)

);

---insert POSTS
INSERT INTO posts (creador_id,equipo_usuario_id,texto,titulo)
values (1,1,'prueba posts','titulo');

--create respuestas --
DROP TABLE IF EXISTS respuestas CASCADE;
CREATE TABLE respuestas
(
         id bigserial primary KEY
        ,comentario text not null
        ,usuario_id bigint not null references usuarios_id(id)
                            on delete no action
                            on update cascade
        ,post_id bigint references posts(id)
                    on delete cascade
                    on update CASCADE
        ,created_at TIMESTAMP(0) default current_timestamp
        , updated_at TIMESTAMP(0) default current_timestamp
        ,padre_id bigint references respuestas(id)
                    ON DELETE cascade
                    ON UPDATE CASCADE
);

insert into respuestas (comentario,post_id,usuario_id)
values ('asdasd',1,1);


--create imagenes predefinias --
DROP TABLE IF EXISTS plantilla CASCADE;
CREATE TABLE plantilla
(
        id bigserial primary key,
        extension varchar(255) not null
);

INSERT INTO plantilla(extension)
VALUES ('png'),('png');

--plantilla usuario --
DROP TABLE IF EXISTS plantilla_usuario CASCADE;
CREATE TABLE plantilla_usuario
(
     id bigserial primary key
    ,usuario_id bigint not null references usuarios(id)
                        on delete cascade
                        on update cascade
    ,url varchar(255)
);

--comentar partidos --
DROP TABLE IF EXISTS comentar_partidos CASCADE;
CREATE TABLE comentar_partidos
(
    id bigserial primary key,
    partido_id bigint not null references partidos(id)
                            on delete cascade
                            on update cascade,
    usuario_id bigint not null references usuarios_id(id)
                            on delete CASCADE
                            on update cascade,
    comentario varchar(255) not NULL,
    created_at TIMESTAMP(0) default current_timestamp
    , updated_at TIMESTAMP(0) default current_timestamp
);
INSERT INTO noticias (titulo,texto,img,created_at,creador_id,subtitulo)
    VALUES ('El betis gana la Champions', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis orci at dolor mollis mollis. Suspendisse volutpat, sapien in sagittis aliquet, urna velit aliquam leo, non iaculis justo ante in tortor. Maecenas in tellus libero. Cras iaculis consectetur tellus eget pretium. Phasellus mollis orci a malesuada vestibulum. Suspendisse potenti. Morbi tincidunt tincidunt massa, ut maximus purus pellentesque eu. Nullam in consequat risus. Nullam aliquet vulputate nibh, id volutpat metus dapibus non. Donec vitae porta enim. Vestibulum urna leo, dapibus in ullamcorper quis, tempus in nibh. Curabitur semper augue eleifend ultricies ultrices.

Etiam iaculis sapien ante, eu feugiat dui venenatis id. Aliquam ac sodales enim. Proin vitae neque scelerisque, tempus urna sit amet, volutpat erat. Aenean dolor ante, auctor non purus eget, lacinia venenatis ligula. Vestibulum ullamcorper maximus nunc, sollicitudin mollis tortor vestibulum vitae. Duis feugiat quis ipsum in fringilla. Nam mollis arcu sed sagittis fringilla. Praesent gravida ipsum eu semper vehicula. Quisque sit amet auctor enim. Maecenas ut eros viverra dui placerat blandit nec eget massa. Integer mattis auctor ante, ut luctus libero faucibus quis. Aliquam pulvinar lacus et nisl dignissim volutpat. Etiam sit amet orci a turpis sollicitudin luctus.

Praesent finibus purus at massa ultricies vulputate. Etiam pellentesque, dui nec interdum interdum, leo dolor porta urna, ut eleifend erat eros non risus. Quisque venenatis venenatis ultrices. Quisque nec tortor id justo egestas fringilla sit amet et augue. Curabitur vulputate mauris mi, gravida pulvinar orci sodales in. Donec congue, odio vel elementum venenatis, sapien enim aliquet nibh, eget lacinia mi est ac tortor. Proin dolor augue, porttitor eget lobortis eget, aliquet vitae turpis.

Nulla hendrerit et diam eu facilisis<h1>0000</h1><script>alert("dsadsa")</script>. Aliquam justo ipsum, consectetur ac faucibus quis, dictum placerat tellus. Praesent ullamcorper bibendum orci, nec hendrerit dolor efficitur pellentesque. Duis at mollis est. Nullam laoreet bibendum hendrerit. Vivamus congue rhoncus mauris, eu sodales lorem congue non. Aliquam massa leo, euismod bibendum ornare vel, tincidunt eu metus. Maecenas in nisl et ipsum scelerisque aliquet. Integer consectetur sem non enim blandit fermentum.

Cras libero elit, posuere sed suscipit ut, tincidunt sed nisi. Nulla vel odio vestibulum, cursus sapien id, commodo nulla. Donec vulputate aliquam libero, vitae aliquet ipsum dignissim quis. Nullam consectetur egestas nibh, vitae pretium urna varius quis. Ut quis tincidunt erat. Nam tempus, sem at accumsan sagittis, massa massa hendrerit metus, vitae venenatis nunc ligula semper enim. Proin condimentum, mi nec ultricies porta, est odio scelerisque sem, et facilisis ipsum velit eu dolor. Donec porta enim at interdum laoreet. Cras bibendum libero arcu, sed lacinia ligula vehicula posuere. Aenean eget euismod magna, at maximus mauris. Vestibulum semper, eros eu placerat porttitor, magna odio tincidunt ligula, id tincidunt ipsum erat at diam. Nunc fermentum dui in tellus hendrerit, a ultrices ligula venenatis. Sed in risus a massa dictum feugiat. Aliquam erat volutpat. ', 'https://www.dropbox.com/s/zth7u2ltvh3ukej/champions_league.jpg?dl=1', '2018-03-06',1,'viva er betis shiquillo'),
('El betis gana la Champions', '

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis orci at dolor mollis mollis. Suspendisse volutpat, sapien in sagittis aliquet, urna velit aliquam leo, non iaculis justo ante in tortor. Maecenas in tellus libero. Cras iaculis consectetur tellus eget pretium. Phasellus mollis orci a malesuada vestibulum. Suspendisse potenti. Morbi tincidunt tincidunt massa, ut maximus purus pellentesque eu. Nullam in consequat risus. Nullam aliquet vulputate nibh, id volutpat metus dapibus non. Donec vitae porta enim. Vestibulum urna leo, dapibus in ullamcorper quis, tempus in nibh. Curabitur semper augue eleifend ultricies ultrices.

Etiam iaculis sapien ante, eu feugiat dui venenatis id. Aliquam ac sodales enim. Proin vitae neque scelerisque, tempus urna sit amet, volutpat erat. Aenean dolor ante, auctor non purus eget, lacinia venenatis ligula. Vestibulum ullamcorper maximus nunc, sollicitudin mollis tortor vestibulum vitae. Duis feugiat quis ipsum in fringilla. Nam mollis arcu sed sagittis fringilla. Praesent gravida ipsum eu semper vehicula. Quisque sit amet auctor enim. Maecenas ut eros viverra dui placerat blandit nec eget massa. Integer mattis auctor ante, ut luctus libero faucibus quis. Aliquam pulvinar lacus et nisl dignissim volutpat. Etiam sit amet orci a turpis sollicitudin luctus.

Praesent finibus purus at massa ultricies vulputate. Etiam pellentesque, dui nec interdum interdum, leo dolor porta urna, ut eleifend erat eros non risus. Quisque venenatis venenatis ultrices. Quisque nec tortor id justo egestas fringilla sit amet et augue. Curabitur vulputate mauris mi, gravida pulvinar orci sodales in. Donec congue, odio vel elementum venenatis, sapien enim aliquet nibh, eget lacinia mi est ac tortor. Proin dolor augue, porttitor eget lobortis eget, aliquet vitae turpis.

Nulla hendrerit et diam eu facilisis. Aliquam justo ipsum, consectetur ac faucibus quis, dictum placerat tellus. Praesent ullamcorper bibendum orci, nec hendrerit dolor efficitur pellentesque. Duis at mollis est. Nullam laoreet bibendum hendrerit. Vivamus congue rhoncus mauris, eu sodales lorem congue non. Aliquam massa leo, euismod bibendum ornare vel, tincidunt eu metus. Maecenas in nisl et ipsum scelerisque aliquet. Integer consectetur sem non enim blandit fermentum.

Cras libero elit, posuere sed suscipit ut, tincidunt sed nisi. Nulla vel odio vestibulum, cursus sapien id, commodo nulla. Donec vulputate aliquam libero, vitae aliquet ipsum dignissim quis. Nullam consectetur egestas nibh, vitae pretium urna varius quis. Ut quis tincidunt erat. Nam tempus, sem at accumsan sagittis, massa massa hendrerit metus, vitae venenatis nunc ligula semper enim. Proin condimentum, mi nec ultricies porta, est odio scelerisque sem, et facilisis ipsum velit eu dolor. Donec porta enim at interdum laoreet. Cras bibendum libero arcu, sed lacinia ligula vehicula posuere. Aenean eget euismod magna, at maximus mauris. Vestibulum semper, eros eu placerat porttitor, magna odio tincidunt ligula, id tincidunt ipsum erat at diam. Nunc fermentum dui in tellus hendrerit, a ultrices ligula venenatis. Sed in risus a massa dictum feugiat. Aliquam erat volutpat. ', 'https://www.dropbox.com/s/oeqfye2gh9pmhdu/descarga.png?dl=1', '2018-03-06',1,'viva er betis shiquillo'),
('El betis gana la Champions', '

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis orci at dolor mollis mollis. Suspendisse volutpat, sapien in sagittis aliquet, urna velit aliquam leo, non iaculis justo ante in tortor. Maecenas in tellus libero. Cras iaculis consectetur tellus eget pretium. Phasellus mollis orci a malesuada vestibulum. Suspendisse potenti. Morbi tincidunt tincidunt massa, ut maximus purus pellentesque eu. Nullam in consequat risus. Nullam aliquet vulputate nibh, id volutpat metus dapibus non. Donec vitae porta enim. Vestibulum urna leo, dapibus in ullamcorper quis, tempus in nibh. Curabitur semper augue eleifend ultricies ultrices.

Etiam iaculis sapien ante, eu feugiat dui venenatis id. Aliquam ac sodales enim. Proin vitae neque scelerisque, tempus urna sit amet, volutpat erat. Aenean dolor ante, auctor non purus eget, lacinia venenatis ligula. Vestibulum ullamcorper maximus nunc, sollicitudin mollis tortor vestibulum vitae. Duis feugiat quis ipsum in fringilla. Nam mollis arcu sed sagittis fringilla. Praesent gravida ipsum eu semper vehicula. Quisque sit amet auctor enim. Maecenas ut eros viverra dui placerat blandit nec eget massa. Integer mattis auctor ante, ut luctus libero faucibus quis. Aliquam pulvinar lacus et nisl dignissim volutpat. Etiam sit amet orci a turpis sollicitudin luctus.

Praesent finibus purus at massa ultricies vulputate. Etiam pellentesque, dui nec interdum interdum, leo dolor porta urna, ut eleifend erat eros non risus. Quisque venenatis venenatis ultrices. Quisque nec tortor id justo egestas fringilla sit amet et augue. Curabitur vulputate mauris mi, gravida pulvinar orci sodales in. Donec congue, odio vel elementum venenatis, sapien enim aliquet nibh, eget lacinia mi est ac tortor. Proin dolor augue, porttitor eget lobortis eget, aliquet vitae turpis.

Nulla hendrerit et diam eu facilisis. Aliquam justo ipsum, consectetur ac faucibus quis, dictum placerat tellus. Praesent ullamcorper bibendum orci, nec hendrerit dolor efficitur pellentesque. Duis at mollis est. Nullam laoreet bibendum hendrerit. Vivamus congue rhoncus mauris, eu sodales lorem congue non. Aliquam massa leo, euismod bibendum ornare vel, tincidunt eu metus. Maecenas in nisl et ipsum scelerisque aliquet. Integer consectetur sem non enim blandit fermentum.

Cras libero elit, posuere sed suscipit ut, tincidunt sed nisi. Nulla vel odio vestibulum, cursus sapien id, commodo nulla. Donec vulputate aliquam libero, vitae aliquet ipsum dignissim quis. Nullam consectetur egestas nibh, vitae pretium urna varius quis. Ut quis tincidunt erat. Nam tempus, sem at accumsan sagittis, massa massa hendrerit metus, vitae venenatis nunc ligula semper enim. Proin condimentum, mi nec ultricies porta, est odio scelerisque sem, et facilisis ipsum velit eu dolor. Donec porta enim at interdum laoreet. Cras bibendum libero arcu, sed lacinia ligula vehicula posuere. Aenean eget euismod magna, at maximus mauris. Vestibulum semper, eros eu placerat porttitor, magna odio tincidunt ligula, id tincidunt ipsum erat at diam. Nunc fermentum dui in tellus hendrerit, a ultrices ligula venenatis. Sed in risus a massa dictum feugiat. Aliquam erat volutpat. ', 'https://www.dropbox.com/s/zth7u2ltvh3ukej/champions_league.jpg?dl=1', '2018-03-06',1,'viva er betis shiquillo'),

('El betis gana la Champions', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis orci at dolor mollis mollis. Suspendisse volutpat, sapien in sagittis aliquet, urna velit aliquam leo, non iaculis justo ante in tortor. Maecenas in tellus libero. Cras iaculis consectetur tellus eget pretium. Phasellus mollis orci a malesuada vestibulum. Suspendisse potenti. Morbi tincidunt tincidunt massa, ut maximus purus pellentesque eu. Nullam in consequat risus. Nullam aliquet vulputate nibh, id volutpat metus dapibus non. Donec vitae porta enim. Vestibulum urna leo, dapibus in ullamcorper quis, tempus in nibh. Curabitur semper augue eleifend ultricies ultrices.

Etiam iaculis sapien ante, eu feugiat dui venenatis id. Aliquam ac sodales enim. Proin vitae neque scelerisque, tempus urna sit amet, volutpat erat. Aenean dolor ante, auctor non purus eget, lacinia venenatis ligula. Vestibulum ullamcorper maximus nunc, sollicitudin mollis tortor vestibulum vitae. Duis feugiat quis ipsum in fringilla. Nam mollis arcu sed sagittis fringilla. Praesent gravida ipsum eu semper vehicula. Quisque sit amet auctor enim. Maecenas ut eros viverra dui placerat blandit nec eget massa. Integer mattis auctor ante, ut luctus libero faucibus quis. Aliquam pulvinar lacus et nisl dignissim volutpat. Etiam sit amet orci a turpis sollicitudin luctus.

Praesent finibus purus at massa ultricies vulputate. Etiam pellentesque, dui nec interdum interdum, leo dolor porta urna, ut eleifend erat eros non risus. Quisque venenatis venenatis ultrices. Quisque nec tortor id justo egestas fringilla sit amet et augue. Curabitur vulputate mauris mi, gravida pulvinar orci sodales in. Donec congue, odio vel elementum venenatis, sapien enim aliquet nibh, eget lacinia mi est ac tortor. Proin dolor augue, porttitor eget lobortis eget, aliquet vitae turpis.

Nulla hendrerit et diam eu facilisis. Aliquam justo ipsum, consectetur ac faucibus quis, dictum placerat tellus. Praesent ullamcorper bibendum orci, nec hendrerit dolor efficitur pellentesque. Duis at mollis est. Nullam laoreet bibendum hendrerit. Vivamus congue rhoncus mauris, eu sodales lorem congue non. Aliquam massa leo, euismod bibendum ornare vel, tincidunt eu metus. Maecenas in nisl et ipsum scelerisque aliquet. Integer consectetur sem non enim blandit fermentum.

Cras libero elit, posuere sed suscipit ut, tincidunt sed nisi. Nulla vel odio vestibulum, cursus sapien id, commodo nulla. Donec vulputate aliquam libero, vitae aliquet ipsum dignissim quis. Nullam consectetur egestas nibh, vitae pretium urna varius quis. Ut quis tincidunt erat. Nam tempus, sem at accumsan sagittis, massa massa hendrerit metus, vitae venenatis nunc ligula semper enim. Proin condimentum, mi nec ultricies porta, est odio scelerisque sem, et facilisis ipsum velit eu dolor. Donec porta enim at interdum laoreet. Cras bibendum libero arcu, sed lacinia ligula vehicula posuere. Aenean eget euismod magna, at maximus mauris. Vestibulum semper, eros eu placerat porttitor, magna odio tincidunt ligula, id tincidunt ipsum erat at diam. Nunc fermentum dui in tellus hendrerit, a ultrices ligula venenatis. Sed in risus a massa dictum feugiat. Aliquam erat volutpat. ', 'https://www.dropbox.com/s/oeqfye2gh9pmhdu/descarga.png?dl=1', '2018-03-06',1,'viva er betis shiquillo'),

('El betis gana la Champions', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis orci at dolor mollis mollis. Suspendisse volutpat, sapien in sagittis aliquet, urna velit aliquam leo, non iaculis justo ante in tortor. Maecenas in tellus libero. Cras iaculis consectetur tellus eget pretium. Phasellus mollis orci a malesuada vestibulum. Suspendisse potenti. Morbi tincidunt tincidunt massa, ut maximus purus pellentesque eu. Nullam in consequat risus. Nullam aliquet vulputate nibh, id volutpat metus dapibus non. Donec vitae porta enim. Vestibulum urna leo, dapibus in ullamcorper quis, tempus in nibh. Curabitur semper augue eleifend ultricies ultrices.

Etiam iaculis sapien ante, eu feugiat dui venenatis id. Aliquam ac sodales enim. Proin vitae neque scelerisque, tempus urna sit amet, volutpat erat. Aenean dolor ante, auctor non purus eget, lacinia venenatis ligula. Vestibulum ullamcorper maximus nunc, sollicitudin mollis tortor vestibulum vitae. Duis feugiat quis ipsum in fringilla. Nam mollis arcu sed sagittis fringilla. Praesent gravida ipsum eu semper vehicula. Quisque sit amet auctor enim. Maecenas ut eros viverra dui placerat blandit nec eget massa. Integer mattis auctor ante, ut luctus libero faucibus quis. Aliquam pulvinar lacus et nisl dignissim volutpat. Etiam sit amet orci a turpis sollicitudin luctus.

Praesent finibus purus at massa ultricies vulputate. Etiam pellentesque, dui nec interdum interdum, leo dolor porta urna, ut eleifend erat eros non risus. Quisque venenatis venenatis ultrices. Quisque nec tortor id justo egestas fringilla sit amet et augue. Curabitur vulputate mauris mi, gravida pulvinar orci sodales in. Donec congue, odio vel elementum venenatis, sapien enim aliquet nibh, eget lacinia mi est ac tortor. Proin dolor augue, porttitor eget lobortis eget, aliquet vitae turpis.

Nulla hendrerit et diam eu facilisis. Aliquam justo ipsum, consectetur ac faucibus quis, dictum placerat tellus. Praesent ullamcorper bibendum orci, nec hendrerit dolor efficitur pellentesque. Duis at mollis est. Nullam laoreet bibendum hendrerit. Vivamus congue rhoncus mauris, eu sodales lorem congue non. Aliquam massa leo, euismod bibendum ornare vel, tincidunt eu metus. Maecenas in nisl et ipsum scelerisque aliquet. Integer consectetur sem non enim blandit fermentum.

Cras libero elit, posuere sed suscipit ut, tincidunt sed nisi. Nulla vel odio vestibulum, cursus sapien id, commodo nulla. Donec vulputate aliquam libero, vitae aliquet ipsum dignissim quis. Nullam consectetur egestas nibh, vitae pretium urna varius quis. Ut quis tincidunt erat. Nam tempus, sem at accumsan sagittis, massa massa hendrerit metus, vitae venenatis nunc ligula semper enim. Proin condimentum, mi nec ultricies porta, est odio scelerisque sem, et facilisis ipsum velit eu dolor. Donec porta enim at interdum laoreet. Cras bibendum libero arcu, sed lacinia ligula vehicula posuere. Aenean eget euismod magna, at maximus mauris. Vestibulum semper, eros eu placerat porttitor, magna odio tincidunt ligula, id tincidunt ipsum erat at diam. Nunc fermentum dui in tellus hendrerit, a ultrices ligula venenatis. Sed in risus a massa dictum feugiat. Aliquam erat volutpat. ', 'https://www.dropbox.com/s/oeqfye2gh9pmhdu/descarga.png?dl=1', '2018-03-06',1,'viva er betis shiquillo');


--INSERT COMENTARIOS --

INSERT INTO comentarios (comentario,usuario_id,noticia_id,padre_id)
values ('cierto muy cierto',1,1,null),
       ('jie',2,1,1);

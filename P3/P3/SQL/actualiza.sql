-- Creamos una tabla auxiliar para orderdetail

CREATE TABLE orderdetail_aux (
    orderid integer NOT NULL,
    prod_id integer NOT NULL,
    price numeric,
    quantity integer NOT NULL
);

-- Insertamos en la nueva tabla los datos correctos de orderdetail
insert into orderdetail_aux(orderid, prod_id, price, quantity) 
select orderid, prod_id, price, sum(quantity) as quantity
from orderdetail
group by orderid, prod_id, price;

-- Eliminamos todos los registros de orderdetail

delete from orderdetail;

-- Copiamos los datos arreglados en la nueva tabla

insert into orderdetail(orderid, prod_id, price, quantity) select * from orderdetail_aux;

-- Eliminamos la tabla auxiliar

DROP TABLE orderdetail_aux;

-- Añadimos las claves primarias de la tabla orderdetail

ALTER TABLE ONLY orderdetail
    ADD CONSTRAINT orderdetail_pkey PRIMARY KEY (orderid, prod_id);

-- Añadimos las claves externas de la tabla orderdetail

ALTER TABLE ONLY orderdetail
    ADD CONSTRAINT orderdetail_orderid_fkey FOREIGN KEY (orderid) REFERENCES orders(orderid);

ALTER TABLE ONLY orderdetail
    ADD CONSTRAINT orderdetail_prod_id_fkey FOREIGN KEY (prod_id) REFERENCES products(prod_id);  

-- Creamos la tabla de los idiomas

CREATE TABLE languages (
	languageid integer NOT NULL,
	languagename character varying(32) NOT NULL,
	extrainformation character varying(128) NOT NULL,
	UNIQUE (languagename, extrainformation)
);

CREATE SEQUENCE languages_languageid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.languages_languageid_seq OWNER TO alumnodb;

ALTER SEQUENCE languages_languageid_seq OWNED BY languages.languageid;

ALTER TABLE ONLY languages ALTER COLUMN languageid SET DEFAULT nextval('languages_languageid_seq'::regclass);

ALTER TABLE ONLY languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (languageid);

-- Creamos la tabla de los países

CREATE TABLE countries (
	countryid integer NOT NULL,
	countryname character varying(32) NOT NULL UNIQUE
);

CREATE SEQUENCE countries_countryid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_countryid_seq OWNER TO alumnodb;

ALTER SEQUENCE countries_countryid_seq OWNED BY countries.countryid;

ALTER TABLE ONLY countries ALTER COLUMN countryid SET DEFAULT nextval('countries_countryid_seq'::regclass);

ALTER TABLE ONLY countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (countryid);

-- Creamos la tabla de los generos

CREATE TABLE genres (
	genreid integer NOT NULL,
	genrename character varying(32) NOT NULL UNIQUE
);

CREATE SEQUENCE genres_genreid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.genres_genreid_seq OWNER TO alumnodb;

ALTER SEQUENCE genres_genreid_seq OWNED BY genres.genreid;

ALTER TABLE ONLY genres ALTER COLUMN genreid SET DEFAULT nextval('genres_genreid_seq'::regclass);

ALTER TABLE ONLY genres
    ADD CONSTRAINT genres_pkey PRIMARY KEY (genreid);

-- Creamos la tabla relación entre imdb_movies con languages

CREATE TABLE imdb_movies_languages (
	movieid integer NOT NULL,
	languageid integer NOT NULL
);

ALTER TABLE ONLY imdb_movies_languages
    ADD CONSTRAINT imdb_movies_languages_pkey PRIMARY KEY (movieid, languageid); 

ALTER TABLE ONLY imdb_movies_languages
    ADD CONSTRAINT imdb_movies_languages_movieid_fkey FOREIGN KEY (movieid) REFERENCES imdb_movies(movieid);  

ALTER TABLE ONLY imdb_movies_languages
    ADD CONSTRAINT imdb_movies_languages_languageid_fkey FOREIGN KEY (languageid) REFERENCES languages(languageid); 


-- Creamos la tabla relación entre imdb_movies con countries

CREATE TABLE imdb_movies_countries (
	movieid integer NOT NULL,
	countryid integer NOT NULL
);


ALTER TABLE ONLY imdb_movies_countries
    ADD CONSTRAINT imdb_movies_countries_pkey PRIMARY KEY (movieid, countryid);

ALTER TABLE ONLY imdb_movies_countries
    ADD CONSTRAINT imdb_movies_countries_movieid_fkey FOREIGN KEY (movieid) REFERENCES imdb_movies(movieid);  

ALTER TABLE ONLY imdb_movies_countries
    ADD CONSTRAINT imdb_movies_countries_countryid_fkey FOREIGN KEY (countryid) REFERENCES countries(countryid); 

-- Creamos la tabla relación entre imdb_movies con genres

CREATE TABLE imdb_movies_genres (
	movieid integer NOT NULL,
	genreid integer NOT NULL
);

ALTER TABLE ONLY imdb_movies_genres
    ADD CONSTRAINT imdb_movies_genres_pkey PRIMARY KEY (movieid, genreid);

ALTER TABLE ONLY imdb_movies_genres
    ADD CONSTRAINT imdb_movies_genres_movieid_fkey FOREIGN KEY (movieid) REFERENCES imdb_movies(movieid);  

ALTER TABLE ONLY imdb_movies_genres
    ADD CONSTRAINT imdb_movies_genres_genreid_fkey FOREIGN KEY (genreid) REFERENCES genres(genreid); 

-- Copiamos los idiomas a la nueva tabla

insert into languages (languagename, extrainformation)
select distinct on(language, extrainformation) language, extrainformation 
from imdb_movielanguages;

insert into imdb_movies_languages (movieid, languageid) 
select movieid, languageid
from imdb_movielanguages ml , languages l
where ml.language = l.languagename and ml.extrainformation = l.extrainformation;

-- Copiamos los paises a la nueva tabla y las relaciones con las peliculas

insert into countries (countryname) select distinct on(country) country from imdb_moviecountries;

insert into imdb_movies_countries (movieid, countryid) 
select movieid, countryid
from imdb_moviecountries mc , countries c
where mc.country = c.countryname;

-- Copiamos los generos a la nueva tabla y las relaciones con las peliculas

insert into genres (genrename) select distinct on(genre) genre from imdb_moviegenres;

insert into imdb_movies_genres (movieid, genreid) 
select movieid, genreid
from imdb_moviegenres mg , genres g
where mg.genre = g.genrename;

-- Eliminamos las tablas antiguas

DROP TABLE imdb_moviecountries;
DROP TABLE imdb_moviegenres;
DROP TABLE imdb_movielanguages;

-- Cambiamos el propietario de las tablas creadas

ALTER TABLE public.imdb_movies_languages OWNER TO alumnodb;
ALTER TABLE public.imdb_movies_countries OWNER TO alumnodb;
ALTER TABLE public.imdb_movies_genres OWNER TO alumnodb;
ALTER TABLE public.languages OWNER TO alumnodb;
ALTER TABLE public.countries OWNER TO alumnodb;
ALTER TABLE public.genres OWNER TO alumnodb;

-- Creamos las columnas necesarias en imdb_movie para adaptarlo a nuestra web

ALTER TABLE imdb_movies ADD image text;

-- Añadimos los datos de esas columnas para las 3 primeras películas de getTopVentas()

UPDATE imdb_movies set image = 'images/illtown.jpg' where movieid = '189256'; -- Película Illtown (1996)
UPDATE imdb_movies set image = 'images/Wizard-of-Oz.jpg' where movieid = '442893'; -- Película Wizard Of Oz
UPDATE imdb_movies set image = 'images/Life_less.jpg' where movieid = '229764'; -- Película A Life Less Ordinary
UPDATE imdb_movies set image = 'images/gang_related.jpg' where movieid = '149475'; -- Película A Gang Related
UPDATE imdb_movies set image = 'images/jerk.jpg' where movieid = '201944'; -- Película The Jerk
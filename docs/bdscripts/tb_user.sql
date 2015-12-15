-- Database: "Zendstrap"

-- DROP DATABASE "Zendstrap";

CREATE DATABASE "Zendstrap"
  WITH OWNER = postgres
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'Portuguese_Brazil.1252'
       LC_CTYPE = 'Portuguese_Brazil.1252'
       CONNECTION LIMIT = -1;

COMMENT ON DATABASE "Zendstrap"
  IS 'Base de dados modelo para a aplicação zendstrap';


-- Table: users

-- DROP TABLE users;

CREATE TABLE users
(
  id serial NOT NULL,
  login character varying(30) NOT NULL DEFAULT ''::character varying,
  hashed_password character varying(40) NOT NULL DEFAULT ''::character varying,
  firstname character varying(30) NOT NULL DEFAULT ''::character varying,
  lastname character varying(30) NOT NULL DEFAULT ''::character varying,
  mail character varying(60) NOT NULL DEFAULT ''::character varying,
  mail_notification boolean NOT NULL DEFAULT true,
  admin boolean NOT NULL DEFAULT false,
  status integer NOT NULL DEFAULT 1,
  last_login_on timestamp without time zone,
  language character varying(5) DEFAULT ''::character varying,
  created_on timestamp without time zone,
  updated_on timestamp without time zone,
  CONSTRAINT users_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE users
  OWNER TO postgres;




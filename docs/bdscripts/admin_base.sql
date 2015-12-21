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


-- Table: systems

-- DROP TABLE systems;

CREATE TABLE systems
(
  id serial NOT NULL,
  name character varying(30) NOT NULL DEFAULT ''::character varying,
  description text,
  is_public boolean NOT NULL DEFAULT true,
  created_on timestamp without time zone,
  updated_on timestamp without time zone,
  identifier character varying(20),
  status integer NOT NULL DEFAULT 1,
  CONSTRAINT systems_pkey PRIMARY KEY (id),
  CONSTRAINT unique_identifier UNIQUE (identifier)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE systems
  OWNER TO postgres;


-- Table: roles

-- DROP TABLE roles;

CREATE TABLE roles
(
  id serial NOT NULL,
  name character varying(30) NOT NULL DEFAULT ''::character varying,
  system_id integer NOT NULL,
  CONSTRAINT roles_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE roles
 OWNER TO postgres;



-- Table: members

-- DROP TABLE members;

CREATE TABLE members
(
  id serial NOT NULL,
  user_id integer NOT NULL DEFAULT 0,
  system_id integer NOT NULL DEFAULT 0,
  created_on timestamp without time zone,
  mail_notification boolean NOT NULL DEFAULT false,
  CONSTRAINT members_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE members
 OWNER TO postgres;


-- Index: index_members_on_project_id

-- DROP INDEX index_members_on_project_id;

CREATE INDEX index_members_on_system_id
  ON members
  USING btree
  (system_id);

-- Index: index_members_on_user_id

-- DROP INDEX index_members_on_user_id;

CREATE INDEX index_members_on_user_id
  ON members
  USING btree
  (user_id);



-- Table: member_roles

-- DROP TABLE member_roles;

CREATE TABLE member_roles
(
  id serial NOT NULL,
  member_id integer NOT NULL,
  role_id integer NOT NULL,
  inherited_from integer,
  CONSTRAINT member_roles_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE member_roles
  OWNER TO postgres;

-- Index: index_member_roles_on_member_id

-- DROP INDEX index_member_roles_on_member_id;

CREATE INDEX index_member_roles_on_member_id
  ON member_roles
  USING btree
  (member_id);

-- Index: index_member_roles_on_role_id

-- DROP INDEX index_member_roles_on_role_id;

CREATE INDEX index_member_roles_on_role_id
  ON member_roles
  USING btree
  (role_id);

-- Table: permissions

-- DROP TABLE permissions;

CREATE TABLE permissions
(
  id serial NOT NULL,
  name character varying(30) NOT NULL DEFAULT ''::character varying,
  action_name character varying(50) NOT NULL DEFAULT ''::character varying, -- Nome da ação utilizada no código  
  system_id integer NOT NULL,
  CONSTRAINT permissions_pkey PRIMARY KEY (id)
  
)
WITH (
  OIDS=FALSE
);
ALTER TABLE permissions
 OWNER TO postgres;
COMMENT ON COLUMN permissions.action_name IS 'Nome da ação utilizada no código';


-- Table: role_permissions

-- DROP TABLE role_permissions;

CREATE TABLE role_permissions
(
  id serial NOT NULL,
  role_id integer NOT NULL,
  permission_id integer NOT NULL,
  CONSTRAINT role_permissions_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE role_permissions
  OWNER TO postgres;

-- Index: index_role_permissions_on_member_id

-- DROP INDEX index_role_permissions_on_member_id;

CREATE INDEX index_role_permissions_on_role_id
  ON role_permissions
  USING btree
  (role_id);

-- Index: index_role_permissions_on_role_id

-- DROP INDEX index_role_permissions_on_role_id;

CREATE INDEX index_member_roles_on_permission_id
  ON role_permissions
  USING btree
  (permission_id);



-- View: vw_users

-- DROP VIEW vw_users;

CREATE OR REPLACE VIEW vw_users AS 
 SELECT u.id,
    u.login,
    u.hashed_password,
    u.firstname,
    u.lastname,
    u.mail,
    u.mail_notification,
    u.admin,
    u.status,
    u.language,
    ( SELECT array_agg(m.system_id) AS array_agg
           FROM members m
          WHERE m.user_id = u.id) AS systems
   FROM users u;

ALTER TABLE vw_users
  OWNER TO postgres;
COMMENT ON VIEW vw_users
  IS 'Retorna as informações do usuário e seus sistemas vinculados';



-- View: vw_roles_permissions

-- DROP VIEW vw_roles_permissions;

CREATE OR REPLACE VIEW vw_roles_permissions AS 
 SELECT m.user_id,
    r.id AS role_id,
    r.name AS role_name,
    r.system_id,
    s.name AS system_name,
    array_agg(rp.permission_id) AS permissions
   FROM roles r
     JOIN member_roles mr ON r.id = mr.role_id
     JOIN members m ON m.id = mr.member_id
     JOIN role_permissions rp ON r.id = rp.role_id
     JOIN systems s ON r.system_id = s.id
  GROUP BY r.id, s.name, m.user_id;

ALTER TABLE vw_roles_permissions
  OWNER TO postgres;
COMMENT ON VIEW vw_roles_permissions
  IS 'Dado um user_id e um system_id, retona os perfis e suas respectivas permissões para o sistema consultado.';


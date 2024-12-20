-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS persona_cod_persona_seq;

-- Table Definition
CREATE TABLE persona (
    "cod_persona" int4 NOT NULL DEFAULT nextval('persona_cod_persona_seq'::regclass),
    "ci_persona" varchar NOT NULL,
    "nom_persona" varchar NOT NULL,
    "ape_persona" varchar NOT NULL,
    "clave_persona" varchar NOT NULL,
    "correo_persona" varchar NOT NULL,
    PRIMARY KEY ("cod_persona")
);

-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS contacto_cod_contacto_seq;

-- Table Definition
CREATE TABLE contacto (
    "cod_contacto" int4 NOT NULL DEFAULT nextval('contacto_cod_contacto_seq'::regclass),
    "nom_contacto" varchar NOT NULL,
    "ape_contacto" varchar NOT NULL,
    "telefono_contacto" varchar,
    "email_contacto" varchar,
    "persona_cod_persona" int4 NOT NULL,
    CONSTRAINT "fk_contacto_persona" FOREIGN KEY ("persona_cod_persona") REFERENCES "persona"("cod_persona"),
    PRIMARY KEY ("cod_contacto")
);
SET client_min_messages TO FATAL;

CREATE DATABASE {DB_NAME};

\c {DB_NAME}

SET client_min_messages TO FATAL;

/* Create member_role type */
CREATE TYPE member_role AS ENUM ('ambassador', 'programmer', 'manager', 'social', 'face');

/* Create registration_status type */
CREATE TYPE registration_status AS ENUM ('open', 'rejected', 'accepted');

/* Create sequence for members */
CREATE SEQUENCE {DB_PREFIX}members_id_seq;

/* Create sequence for registrations */
CREATE SEQUENCE {DB_PREFIX}registrations_id_seq;

/* Create table registrations */
CREATE TABLE "{DB_PREFIX}registrations" (
    "id" integer NOT NULL DEFAULT NEXTVAL('{DB_PREFIX}registrations_id_seq'),
    "player_name" varchar(50) NOT NULL,
    "email" varchar(100) NOT NULL,
    "name" varchar(100) NOT NULL,
    "date" timestamp DEFAULT NOW(),
    "function" member_role NOT NULL,
    "letter" varchar(1000) NOT NULL,
    "status" registration_status DEFAULT 'open',
    PRIMARY KEY ("id")
);

/* Create table members */
CREATE TABLE "{DB_PREFIX}members" (
    "id" integer NOT NULL DEFAULT NEXTVAL('{DB_PREFIX}members_id_seq'),
    "password" varchar(40) NOT NULL,
    "email" varchar(100) NOT NULL,
    "registration_id" integer NOT NULL,
    "forum_member_id" integer NULL,
    "name" varchar(50) NOT NULL,
    "suspended" boolean DEFAULT FALSE,
    PRIMARY KEY ("id"),
    FOREIGN KEY ("registration_id") REFERENCES "{DB_PREFIX}registrations"("id")
);

/* Create table roles */
CREATE TABLE "{DB_PREFIX}roles" (
	"member_id" integer NOT NULL,
	"role" member_role NOT NULL,
	PRIMARY KEY ("member_id", "role"),
	FOREIGN KEY ("member_id") REFERENCES "{DB_PREFIX}members"("id")
);

/* Create table tribes */
CREATE TABLE "{DB_PREFIX}tribes" (
	"id" integer NOT NULL,
	"name" varchar(24) NOT NULL,
	"tag" varchar(6) NOT NULL,
	PRIMARY KEY ("id")
);

/* Create table players */
CREATE TABLE "{DB_PREFIX}players" (
	"id" integer NOT NULL,
	"name" varchar(24) NOT NULL,
	"tribe_id" integer NULL,
    "points" integer NOT NULL,
    "rank" integer NOT NULL,
	PRIMARY KEY ("id"),
	FOREIGN KEY ("tribe_id") REFERENCES "{DB_PREFIX}tribes"("id")
);

/* Create table certificates */
CREATE TABLE "{DB_PREFIX}certificates" (
	"player_id" integer NOT NULL,
	"role_member_id" integer NOT NULL,
	"role_role" member_role NOT NULL,
	"date" timestamp NOT NULL,
	"end_date" timestamp NOT NULL,
	PRIMARY KEY ("player_id", "date"),
	FOREIGN KEY ("player_id") REFERENCES "{DB_PREFIX}players"("id"),
	FOREIGN KEY ("role_member_id", "role_role") REFERENCES "{DB_PREFIX}roles"("member_id", "role"),
	CHECK ("role_role"='ambassador')
);

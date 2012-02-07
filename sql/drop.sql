\c {DB_NAME};

SET client_min_messages TO FATAL;

/* Drop table certificates */
DROP TABLE IF EXISTS "{DB_PREFIX}certificates";

/* Drop table players */
DROP TABLE IF EXISTS "{DB_PREFIX}players";

/* Drop table tribes */
DROP TABLE IF EXISTS "{DB_PREFIX}tribes";

/* Drop table roles */
DROP TABLE IF EXISTS "{DB_PREFIX}roles";

/* Drop table members */
DROP TABLE IF EXISTS "{DB_PREFIX}members";

/* Drop table registrations */
DROP TABLE IF EXISTS "{DB_PREFIX}registrations";

DROP TYPE IF EXISTS "member_role";
DROP TYPE IF EXISTS "registration_type";
DROP SEQUENCE IF EXISTS "{DB_PREFIX}members_id_seq";
DROP SEQUENCE IF EXISTS "{DB_PREFIX}registrations_id_seq"

CREATE DATABASE IF NOT EXISTS agile_board;
USE agile_board;

INSERT INTO roles VALUES (0, "administrator");
INSERT INTO roles VALUES (1, "user");

INSERT INTO users VALUES (0, "admin", "admin", "admin", "admin", 0);
INSERT INTO users VALUES (1, "user", "user", "user", "user", 1);
INSERT INTO users VALUES (2, "alex", "alexey", "tregubov", "alexey", 1);

/*

--Table to store different types of roles in the system (like user, admin etc)
CREATE TABLE roles(
role_id_pk INT,
role_name VARCHAR(20),
PRIMARY KEY(role_id_pk)
);


--Table to store user details
CREATE TABLE users(
user_id_pk VARCHAR(30),
user_login VARCHAR(40),
user_first_name VARCHAR(40),
user_last_name VARCHAR(40),
user_password VARCHAR(20),
user_role_fk INT,
FOREIGN KEY (user_role_fk) REFERENCES roles(role_id_pk),
PRIMARY KEY(user_id_pk)
);
*/
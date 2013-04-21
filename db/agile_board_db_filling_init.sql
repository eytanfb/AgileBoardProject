USE agileboard;

INSERT INTO roles VALUES (0, "user");
INSERT INTO roles VALUES (1, "administrator");

INSERT INTO users VALUES ("admin", "admin", "admin", "admin", "admin", 1);
INSERT INTO users VALUES ("user", "user", "user", "user", "user", 0);
INSERT INTO users VALUES ("alex", "alex", "alexey", "tregubov", "alexey", 0);
INSERT INTO users VALUES ("ramtin", "ramtin", "ramtin", "ramtin", "ramtin", 0);
INSERT INTO users VALUES ("abhishek", "abhishek", "abhishek", "abhishek", "abhishek", 0);
INSERT INTO users VALUES ("eytan", "eytan", "Eytan", "Anjel", "eytan", 0);
INSERT INTO users VALUES ("linus", "linus", "Linus", "Torvalds", "linus", 0);
INSERT INTO users VALUES ("kirill", "kirill", "Kirill", "Golodets", "kirill", 0);
INSERT INTO users VALUES ("richard", "richard", "Richard", "Stallman", "richard", 0);
INSERT INTO users VALUES ("doc", "doc", "Emmett", "Brown", "doc", 0);
INSERT INTO users VALUES ("marty", "marty", "Marty", "McFly", "marty", 0);
INSERT INTO users VALUES ("nicolaus", "nicolaus", "Nicolaus", "Copernicus", "nicolaus", 0);
INSERT INTO users VALUES ("isaac", "isaac", "Isaac", "Newton", "isaac", 0);
INSERT INTO users VALUES ("alan", "alan", "Alan", "Turing", "alan", 0);
INSERT INTO users VALUES ("charles", "charles", "Charles", "Babbage", "charles", 0);
INSERT INTO users VALUES ("james", "james", "James", "Gosling", "james", 0);

INSERT INTO teams VALUES (1, "Agile Board team", "This is 511 project", 1);
INSERT INTO teams VALUES (2, "Test team #2", "This is also 511 project", 1);

INSERT INTO team_users VALUES ("user", 1);
INSERT INTO team_users VALUES ("alex", 1);
INSERT INTO team_users VALUES ("ramtin", 2);
INSERT INTO team_users VALUES ("abhishek", 2);


INSERT INTO statuses VALUES ("TODO", "TODO");
INSERT INTO statuses VALUES ("DOING", "DOING");
INSERT INTO statuses VALUES ("DONE", "DONE");

INSERT INTO boards VALUES (1, 1, "Team 1, agile board", 0);
INSERT INTO boards VALUES (2, 2, "Team 2 board", 0);

INSERT INTO iterations VALUES (1,'2013-3-03', '2013-3-10', 1, 1, 7);
INSERT INTO iterations VALUES (2,'2013-3-11', '2013-3-18', 1, 1, 7);
INSERT INTO iterations VALUES (3,'2013-3-19', '2013-3-26', 1, 0, 7);

INSERT INTO iterations VALUES (4,'2013-3-04', '2013-3-11', 2, 1, 7);
INSERT INTO iterations VALUES (5,'2013-3-13', '2013-3-18', 2, 1, 7);
INSERT INTO iterations VALUES (6,'2013-3-20', '2013-3-27', 2, 0, 7);


INSERT INTO tasks VALUES (1, "Task1: design DB", "design ER schema", "ramtin", "ramtin", 15, 6, "TODO");

insert into change_types values(1, 'create_task');
insert into change_types values(2, 'update_task');
insert into change_types values(3, 'delete_task');

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


CREATE TABLE teams(
team_id_pk INT NOT NULL AUTO_INCREMENT,
team_name VARCHAR(30),
team_description VARCHAR(100),
PRIMARY KEY(team_id_pk)
);

CREATE TABLE team_users(
tu_user_id_pk_fk INT,
tu_team_id_pk_fk INT,
PRIMARY KEY(tu_user_id_pk_fk, tu_team_id_pk_fk),
FOREIGN KEY (tu_user_id_pk_fk) REFERENCES users(user_id_pk),
FOREIGN KEY (tu_team_id_pk_fk) REFERENCES teams(team_id_pk)
);


CREATE TABLE boards(
board_id_pk INT,
bt_id_fk INT,
board_name VARCHAR(20),
board_isArchived CHAR,
PRIMARY KEY(board_id_pk),
FOREIGN KEY(bt_id_fk) REFERENCES teams(team_id_pk)
);

CREATE TABLE iterations(
iteration_id_pk INT,
iteration_start_date DATE,
iteration_end_date DATE,
ib_id_fk INT,
iteration_isArchived CHAR,
iteration_number INT,
PRIMARY KEY(iteration_id_pk),
FOREIGN KEY(ib_id_fk) REFERENCES boards(board_id_pk)
);


CREATE TABLE statuses(
status_id_pk INT,
status_name VARCHAR(40),
PRIMARY KEY(status_id_pk)
);


CREATE TABLE tasks(
task_id_pk INT,
task_name VARCHAR(40),
task_description VARCHAR(100),
task_creator_id_fk INT,
taks_responsible_person_fk INT,
task_work_estimation INT,
ti_id_fk INT,
ts_id_fk INT,
PRIMARY KEY(task_id_pk),
FOREIGN KEY (task_creator_id_fk) REFERENCES users(user_id_pk),
FOREIGN KEY (taks_responsible_person_fk) REFERENCES users(user_id_pk),
FOREIGN KEY (ti_id_fk) REFERENCES iterations(iteration_id_pk),
FOREIGN KEY (ts_id_fk) REFERENCES statuses(status_id_pk)
);

CREATE TABLE change_types(
change_type_id_pk INT,
change_type_name VARCHAR(30),
PRIMARY KEY(change_type_id_pk)
);


CREATE TABLE task_action_log(
tal_id_pk INT,
tal_user_id_fk INT,
tal_date DATE,
tal_change_type_id_fk INT,
tal_task_id_fk INT,
tal_old_attribute_value VARCHAR(200),
tal_new_attribute_value VARCHAR(200),
PRIMARY KEY(tal_id_pk),
FOREIGN KEY (tal_user_id_fk) REFERENCES users(user_id_pk),
FOREIGN KEY (tal_change_type_id_fk) REFERENCES change_types(change_type_id_pk),
FOREIGN KEY (tal_task_id_fk) REFERENCES tasks(task_id_pk)
);

*/

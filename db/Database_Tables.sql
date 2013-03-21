--Table to store different types of roles in the system (like user, admin etc)
CREATE TABLE roles(
role_id_pk INT,
role_name VARCHAR(20),
PRIMARY KEY(role_id_pk)
);


--Table to store user details
CREATE TABLE users(
user_id_pk VARCHAR(30),
user_first_name VARCHAR(40),
user_last_name VARCHAR(40),
user_password VARCHAR(20),
user_role_fk INT,
FOREIGN KEY (user_role_fk) REFERENCES roles(role_id_pk),
PRIMARY KEY(user_id_pk)
);


--Table to store team details
CREATE TABLE teams(
team_id_pk VARCHAR(20),
team_name VARCHAR(30),
team_description VARCHAR(100),
PRIMARY KEY(team_id_pk)
);

   ALTER TABLE `teams` CHANGE `team_id_pk` `team_id_pk` INT( 11 ) NOT NULL AUTO_INCREMENT 


--Table to store the mapping of users to teams
CREATE TABLE team_users(
tu_user_id_pk_fk VARCHAR(30),
tu_team_id_pk_fk VARCHAR(20),
PRIMARY KEY(tu_user_id_pk_fk, tu_team_id_pk_fk),
FOREIGN KEY (tu_user_id_pk_fk) REFERENCES users(user_id_pk),
FOREIGN KEY (tu_team_id_pk_fk) REFERENCES teams(team_id_pk)
);


--Table to store board details
CREATE TABLE boards(
board_id_pk VARCHAR(20),
bt_id_fk VARCHAR(20),
board_name VARCHAR(20),
board_isArchived CHAR,
PRIMARY KEY(board_id_pk),
FOREIGN KEY(bt_id_fk) REFERENCES teams(team_id_pk)
);


--Table to store iteration details
CREATE TABLE iterations(
iteration_id_pk VARCHAR(30),
iteration_start_date DATE,
iteration_end_date DATE,
ib_id_fk VARCHAR(20),
iteration_isArchived CHAR,
iteration_number INT,
PRIMARY KEY(iteration_id_pk),
FOREIGN KEY(ib_id_fk) REFERENCES boards(board_id_pk)
);


--Table to store status type details
CREATE TABLE statuses(
status_id_pk VARCHAR(10),
status_name VARCHAR(40),
PRIMARY KEY(status_id_pk)
);


--Table to store task details
CREATE TABLE tasks(
task_id_pk VARCHAR(10),
task_name VARCHAR(40),
task_description VARCHAR(100),
task_creator_id_fk VARCHAR(30),
taks_responsible_person_fk VARCHAR(30),
task_work_estimation INT,
ti_id_fk VARCHAR(30),
ts_id_fk VARCHAR(10),
PRIMARY KEY(task_id_pk),
FOREIGN KEY (task_creator_id_fk) REFERENCES users(user_id_pk),
FOREIGN KEY (taks_responsible_person_fk) REFERENCES users(user_id_pk),
FOREIGN KEY (ti_id_fk) REFERENCES iterations(iteration_id_pk),
FOREIGN KEY (ts_id_fk) REFERENCES statuses(status_id_pk)
);

--Table to store details of which change types can be made on the table
CREATE TABLE change_types(
change_type_id_pk VARCHAR(5),
change_type_name VARCHAR(30),
PRIMARY KEY(change_type_id_pk)
);

--Table to store change logs
CREATE TABLE task_action_log(
tal_id_pk VARCHAR(5),
tal_user_id_fk VARCHAR(30),
tal_date DATE,
tal_change_type_id_fk VARCHAR(5),
tal_task_id_fk VARCHAR(10),
tal_old_attribute_value VARCHAR(200),
tal_new_attribute_value VARCHAR(200),
PRIMARY KEY(tal_id_pk),
FOREIGN KEY tal_user_id_fk REFERENCES users(user_id_pk),
FOREIGN KEY (tal_change_type_id_fk) REFERENCES change_types(change_type_id_pk),
FOREIGN KEY (tal_task_id_fk) REFERENCES tasks(task_id_pk)
);

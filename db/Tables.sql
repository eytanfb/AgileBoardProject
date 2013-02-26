CREATE DATABASE IF NOT EXISTS agile_board;
USE agile_board;

CREATE TABLE IF NOT EXISTS tblCredentials(
UserName VARCHAR(50),
F_Name VARCHAR(50),
L_Name VARCHAR(50),
Passwrd VARCHAR(50),
Team_Num INT,
PRIMARY KEY(UserName)
);


CREATE TABLE IF NOT EXISTS tblAdmin(
UserName VARCHAR(50),
Passwrd VARCHAR(50),
F_Name VARCHAR(50),
L_Name VARCHAR(50),
PRIMARY KEY(UserName)
);

INSERT INTO tblCredentials VALUES ("alex", "alexey", "tregubov", "ta123", 1);
INSERT INTO tblCredentials VALUES ("abhishek", "abhishek", "chauhan", "ac123", 1);

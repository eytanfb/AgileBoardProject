DROP TABLE tblCredentials;

CREATE TABLE tblCredentials(
UserName VARCHAR(50),
F_Name VARCHAR(50),
L_Name VARCHAR(50),
Passwrd VARCHAR(50),
Team_Num INT,
PRIMARY KEY(UserName)
);

DROP TABLE tblAdmin;

CREATE TABLE tblAdmin(
UserName VARCHAR(50),
Passwrd VARCHAR(50),
F_Name VARCHAR(50),
L_Name VARCHAR(50),
PRIMARY KEY(UserName)
);


SELECT * FROM tblCredentials;
SELECT * FROM tblAdmin;

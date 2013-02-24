DROP FUNCTION fnInsertUser;

DELIMITER $$
CREATE Function fnInsertUser
   ( username VARCHAR(50), f_name VARCHAR(50), l_name VARCHAR(50), passwrd VARCHAR(50), Team_Num INT  )
   RETURNS INT

   
BEGIN
    INSERT INTO tblCredentials VALUES(
    username, f_name, l_name, passwrd, Team_Num
    );
    IF(ROW_COUNT() !=0) THEN
          RETURN 1;
    ELSE
          RETURN -1;

    END IF;
    
END;
$$
DELIMITER ;

SELECT fnInsertUser('chauhana@usc.edu', 'Abhishek', 'Chauhan', 'password', 1);


SELECT * FROM tblCredentials;



DROP FUNCTION fnInsertAdmin;
DELIMITER $$

CREATE Function fnInsertAdmin
   ( username VARCHAR(50), F_Name VARCHAR(50), L_Name VARCHAR(50), passwrd VARCHAR(50)  )
   RETURNS INT
   
BEGIN
    INSERT INTO tblAdmin VALUES(
    username, F_Name, L_Name, passwrd
    );
    INSERT INTO tblCredentials VALUES(
    username, f_name, l_name, passwrd, -1
    );
    IF(ROW_COUNT() !=0) THEN
          RETURN 1;
    ELSE
          RETURN -1;

    END IF;
    
    
END;
$$

DELIMITER ;
SELECT fninsertadmin('abhishekchauhan1503', 'abhishek', 'chauhan', 'password');

SELECT * FROM tblAdmin;

DROP FUNCTION fnCheckLogin;

DELIMITER $$
CREATE FUNCTION fnCheckLogin
(
email VARCHAR(50),
pass VARCHAR(50),
teamnum INT
)
RETURNS INT

BEGIN
DECLARE tot INT;
SELECT COUNT(*) INTO tot FROM tblCredentials WHERE UserName = email AND passwrd = pass AND Team_Num = teamnum;
IF tot = 1 THEN
    IF teamnum = -1 THEN
        RETURN 1; -- Admin
    ELSE
        RETURN 0; -- Regular User
    END IF;
ELSE
  RETURN -1;  -- Does not Exist
END IF;
END;
$$

DELIMITER ;
SELECT fnCheckLogin('chauhana@usc.edu', 'password' ,1);
SELECT fnCheckLogin('abhishekchauhan1503', 'password' ,-1);
SELECT fnCheckLogin('aaa', 'ppp' ,0);

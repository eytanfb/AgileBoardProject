<?php
	require('constants.php');
	
	$connection = mysql_connect(SERVER,USERNAME,PASSWORD);

	if (!$connection)
	{
		die("Database connection failed! mysql error: ". mysql_error());
	}
	
	$db = mysql_select_db(DBNAME);
	if (!$db)
	{
		die("Database does not exist! mysql error: ".mysql_error());
	}

?>
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

	$connectioni = mysqli_connect(SERVER,USERNAME,PASSWORD);

	if (!$connectioni)
	{
		die("Database connection failed! mysql error: ". mysqli_error());
	}
	
	$dbi = mysqli_select_db($connectioni, DBNAME);
	if (!$dbi)
	{
		die("Database does not exist! mysql error: ".mysqli_error());
	}

?>

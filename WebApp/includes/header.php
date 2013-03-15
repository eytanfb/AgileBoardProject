<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Agile Board Project</title>
		<link href="stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php if ( strstr(strtolower($_SERVER['PHP_SELF']),'login.php') != 'login.php' ): ?>
		<div id="header" >
			
			<div id="left"><?php echo $_SESSION['team_name']; ?></div>
			<div id="center">Board Name:</div>
			<div id="right"><?php echo $_SESSION["user_name"]; ?></div>
				
		</div>
		<?php endif; ?>
		<div id="main">
			
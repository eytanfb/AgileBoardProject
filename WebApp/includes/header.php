<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Agile Board Project</title>
		<link href="stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />		

		<!-- Theme -->
		<link rel="Stylesheet" href="controls/jquery-ui-themes-1-1.10.2/themes/blitzer/jquery-ui.css" />
		<link rel="Stylesheet" href="controls/jquery-ui-themes-1-1.10.2/themes/blitzer/jquery.ui.theme.css" />
		
		<!-- jquery UI -->
		<script src="controls/jquery-ui-1-2.10.2.custom/js/jquery-1.9.1.js"></script>
		<script src="controls/jquery-ui-1-2.10.2.custom/js/jquery-ui-1.10.2.custom.js"></script>
		<script src="controls/comboBox.js"></script>
		
		
		<!-- DataTables plugin -->
		<style type="text/css" title="currentStyle">
			@import "controls/DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" src="controls/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>	

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
			
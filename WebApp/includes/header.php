<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Agile Board Project</title>
		<link href="stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />		

		<!-- Theme -->
		<link rel="Stylesheet" href="controls/jquery-ui-themes-1-1.10.2/themes/blitzer/jquery-ui.css" />
		<link rel="Stylesheet" href="controls/jquery-ui-themes-1-1.10.2/themes/blitzer/jquery.ui.theme.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="stylesheets/bootstrap_extension.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="fontawesome/css/font-awesome.css" type="text/css" charset="utf-8" />
		
		<!-- jquery UI -->
		<script src="controls/jquery-ui-1-2.10.2.custom/js/jquery-1.9.1.js"></script>
		<script src="controls/jquery-ui-1-2.10.2.custom/js/jquery-ui-1.10.2.custom.js"></script>
		<script src="controls/comboBox.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js" charset="utf-8"></script>
    
		<!-- DataTables plugin -->
		<style type="text/css" title="currentStyle">
			@import "controls/DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" src="controls/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>	

	</head>
	<body>
		<?php if ( strstr(strtolower($_SERVER['PHP_SELF']),'login.php') != 'login.php' ): ?>
		
      <div id="header" class="navbar navbar-top">
  			<div id="left">Team: <?php echo $_SESSION['team_name']; ?></div>
  			<div id="center1">Board: <?php echo $_SESSION['board_name']; ?></div>
  			<div id="center2">Iteration: <?php echo $_SESSION['iteration_number'] . ' (' . $_SESSION['iteration_start_date'] . '/' . $_SESSION['iteration_end_date'] . ') '; ?></div>
  			<div id="right">User: <?php echo $_SESSION["user_name"]; ?> <a id="logout" href="logout.php">(Logout)</a></div>
      </div>
    
    <!-- <div id="header" class="ui-widget  ui-corner-all">
      

    </div> -->
		<?php endif; ?>
		<div id="main">
			
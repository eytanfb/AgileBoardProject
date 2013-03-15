<?php

	require_once('includes/session.php');
	
	clear_session();
	
	header("Location: login.php?action=logout");

?>
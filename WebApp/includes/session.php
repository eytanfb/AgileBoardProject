<?php

	session_start();
	
	function set_session($user,$team)
	{
		$_SESSION['username'] = $user['UserName'];
		$_SESSION['user_name'] = $user['F_Name'] . ' ' .$user['L_Name'];
		$_SESSION['team_num'] = $user['Team_Num'];
		$_SESSION['team_name'] = $team['team_name'];
	}
	
	function is_loggedin()
	{
		if ( !isset($_SESSION['username']) )
		{
			return false;
		}
		
		return true;
	}
	
	function check_authentication()
	{
		if ( !is_loggedin() )
		{
			header("Location: login.php");
		}
	}
	
	function clear_session()
	{
		$_SESSION = array();

		if (isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(), "", time() - 60*60*24*7, "/");
		}

		session_destroy();
	}

?>
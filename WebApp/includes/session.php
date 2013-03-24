<?php

	session_start();
	
	function set_session($user,$team)
	{
		$_SESSION['username'] = $user['user_login'];
		$_SESSION['user_name'] = $user['user_first_name'] . ' ' .$user['user_last_name'];
		$_SESSION['team_num'] = $team['team_id_pk'];
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
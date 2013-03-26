<?php

	session_start();
	
	function set_session($user)
	{
		$_SESSION['user_id'] = $user['user_id_pk'];
		$_SESSION['username'] = $user['user_login'];
		$_SESSION['user_name'] = $user['user_first_name'] . ' ' .$user['user_last_name'];
<<<<<<< HEAD
		$_SESSION['team_id'] = $user['tu_team_id_pk_fk'];
=======
		$_SESSION['isAdmin'] = $user['user_login'];
		$_SESSION['team_id'] = $user['tu_user_id_pk_fk'];
>>>>>>> s
		$_SESSION['team_name'] = $user['team_name'];
		$_SESSION['board_id'] = $user['bt_id_fk'];
		$_SESSION['board_name'] = $user['board_name'];
		$_SESSION['iteration_id'] = $user['iteration_id_pk'];
		$_SESSION['iteration_start_date'] = $user['iteration_start_date'];		
		$_SESSION['iteration_end_date'] = $user['iteration_end_date'];				
		$_SESSION['iteration_number'] = $user['iteration_number'];								
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
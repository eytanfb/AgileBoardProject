<?php

	session_start();
	
	function set_session($user)
	{
		$_SESSION['user_id'] = $user['user_id_pk'];
		$_SESSION['username'] = $user['user_login'];
		$_SESSION['user_name'] = $user['user_first_name'] . ' ' .$user['user_last_name'];
		$_SESSION['user_role'] = $user['user_role_fk'];		
		$_SESSION['team_id'] = $user['tu_team_id_pk_fk'];
		$_SESSION['team_name'] = $user['team_name'];
		$_SESSION['board_id'] = $user['bt_id_fk'];
		$_SESSION['board_name'] = $user['board_name'];
		$_SESSION['iteration_id'] = $user['iteration_id_pk'];
		$_SESSION['iteration_start_date'] = $user['iteration_start_date'];		
		$_SESSION['iteration_end_date'] = $user['iteration_end_date'];				
		$_SESSION['iteration_number'] = $user['iteration_number'];								
	}
	
	function update_session_foradmin($iterationID)
	{
		$iquery= "SELECT * FROM boards LEFT JOIN iterations ON ( iterations.ib_id_fk=boards.board_id_pk ) LEFT JOIN teams ON (boards.bt_id_fk =teams.team_id_pk) WHERE iterations.iteration_id_pk='{$iterationID}' LIMIT 1";
		$iitems = mysql_query($iquery);
		$iquery = mysql_fetch_array($iitems);
		
		$_SESSION['team_id'] = $iquery['team_id_pk'];
		$_SESSION['team_name'] = $iquery['team_name'];
		$_SESSION['board_id'] = $iquery['board_id_pk'];
		$_SESSION['board_name'] = $iquery['board_name'];
		$_SESSION['iteration_id'] = $iquery['iteration_id_pk'];
		$_SESSION['iteration_start_date'] = $iquery['iteration_start_date'];		
		$_SESSION['iteration_end_date'] = $iquery['iteration_end_date'];				
		$_SESSION['iteration_number'] = $iquery['iteration_number'];												
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
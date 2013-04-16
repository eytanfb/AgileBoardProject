<?php
	require_once('connection.php');
	session_start();
	function set_session()
	{		
		global $connection;

		$query= "SELECT * FROM users LEFT JOIN roles ON ( users.user_role_fk = roles.role_id_pk ) LEFT JOIN team_users ON ( team_users.tu_user_id_pk_fk = users.user_id_pk ) LEFT JOIN teams ON (teams.team_id_pk=team_users.tu_team_id_pk_fk) LEFT JOIN boards ON ( boards.bt_id_fk=team_users.tu_team_id_pk_fk ) LEFT JOIN iterations ON ( iterations.ib_id_fk=boards.board_id_pk ) WHERE (iterations.iteration_isArchived = 0 OR users.user_role_fk = 1 OR (iterations.iteration_isArchived IS NULL AND users.user_role_fk = 0))AND ( users.user_login = '{$_SESSION['Email']}') ORDER BY iterations.iteration_start_date DESC LIMIT 1";
		$result_set = mysql_query($query, $connection) or die(mysql_error());

		if (mysql_num_rows($result_set)  == 1 )
		{
			//Email was found in the DB, init session:
			$user = mysql_fetch_array($result_set);
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
		else
		{
			// Email was not found in the DB. 
			// Inserting new user with specified Email:
			$password = "no_password";
			$query="INSERT INTO `users`(`user_id_pk`, `user_login`, `user_first_name`, `user_last_name`, `user_password`, `user_role_fk`) VALUES ('{$_SESSION['UserId']}', '{$_SESSION['Email']}', '{$_SESSION['FirstName']}', '{$_SESSION['LastName']}', '{$password}', '{$_SESSION['level']}')";
			mysql_query($query, $connection) or die(mysql_error());

/*
			// check if team exits; if no, then create a new team
			$query = "SELECT * FROM `teams` WHERE users.user_id = '{$_SESSION['Team']}' LIMIT 1";
			$result_set = mysql_query($query, $connection);
			if (mysql_num_rows($result_set)  == 1 )
			{	// team found
				$team = mysql_fetch_array($result_set);
				$_SESSION['team_name'] = $team['team_name'];
				$_SESSION['team_id'] = $team['team_id_pk'];
				// add student to the team:
				$query = "INSERT INTO `team_users`(`tu_user_id_pk_fk`, `tu_team_id_pk_fk`) VALUES ('{$_SESSION['UserId']}','{$_SESSION['Team']}')";
				mysql_query($query, $connection) or die(mysql_error());			

			} else 
			{	// add team
				$query = "INSERT INTO `teams`(`team_id_pk`, `team_name`, `team_description`, `iteration_length`) VALUES ('{$_SESSION['Team']}','{$_SESSION['Team']}','no description', '1')";
				mysql_query($query, $connection) or die(mysql_error());			
				// add student to the team:
				$query = "INSERT INTO `team_users`(`tu_user_id_pk_fk`, `tu_team_id_pk_fk`) VALUES ('{$_SESSION['UserId']}','{$_SESSION['Team']}')";
				mysql_query($query, $connection) or die(mysql_error());
			}
*/

			//init session:
			$_SESSION['user_name'] = $_SESSION['FirstName'] . ' ' .$_SESSION['LastName'];
			$_SESSION['user_role'] = $_SESSION['level'];
			// team is not initialized yes, so I put empty strings there.
			$_SESSION['team_id'] = "";
			$_SESSION['team_name'] = "";
			$_SESSION['board_id'] = "";
			$_SESSION['board_name'] = "";
			$_SESSION['iteration_id'] = "";
			$_SESSION['iteration_start_date'] = "";		
			$_SESSION['iteration_end_date'] = "";
			$_SESSION['iteration_number'] = "";

		}
		//redirect authenticated user to main page
		header("Location: board.php");	
	
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
		if ( !isset($_SESSION['Email']) )
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

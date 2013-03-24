<?php require_once('includes/session.php');  ?>
<?php require_once('includes/connection.php'); ?>
<?php

	if (is_loggedin())
	{
		header("Location: index.php");
	}
	
	if (isset($_POST['submit']))
	{
		//Form has been submitted
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		
		if (empty($username) || empty($password) )
		{
			$message = "Please enter both username and password!";
		}
		else
		{
			$query= "SELECT * FROM users JOIN roles ON ( users.user_role_fk = roles.role_id_pk ) JOIN team_users ON ( team_users.tu_user_id_pk_fk = users.user_id_pk )  WHERE ( users.user_login = '{$username}') AND ( users.user_password = '{$password}' ) LIMIT 1";
			$result_set = mysql_query($query, $connection);

			if (mysql_num_rows($result_set)  == 1 )
			{
				//Correct username and password
				$user = mysql_fetch_array($result_set);
				
				$subquery = "SELECT * FROM teams WHERE team_id_pk='{$user["tu_team_id_pk_fk"]}' LIMIT 1";
				$team_list = mysql_query($subquery,$connection);
				$team = mysql_fetch_array($team_list);
				set_session($user,$team);
				//redirect authenticated user to main page
				header("Location: index.php");	
			}
			else
			{
				$message='Invalid username or password!';
			}
		}
	}
	elseif (isset($_GET['action']) && $_GET['action'] == "logout" )
	{
		$message = "You are now logout!";
	}

?>
<?php include("includes/header.php"); ?>
<form action="login.php" method="post">
	<table align="center">
		<tr>
			<td>username:</td>
			<td><input name="username" type="text" maxlength="20" /></td>
		</tr>
		<tr>
			<td>password:</td>
			<td><input name="password" type="password" maxlength="20" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="login" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php if(!empty($message)) { echo "<p class='errorMessage'>". $message ."</p>"; } ?>
			</td>
		</td>
	</table>
</form>
<?php include('includes/footer.php'); ?>

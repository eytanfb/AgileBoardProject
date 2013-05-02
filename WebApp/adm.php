<?php require_once('includes/session.php');  ?>
<?php require_once('includes/connection.php'); ?>
<?php
        echo "<script language='javascript' type='text/javascript'>";
	# comment next line for development mode. This line works only on the greenbay server.
        #echo "window.location.href=(\"../../cs577auth/auth/ulogin.php?redirect=".$_SERVER['SCRIPT_NAME']."\")";
        echo "</script>";
?>

<?php
	//debug only
	if (isset($_POST['submit']))
	{
		//Form has been submitted
		$Email = trim($_POST["Email"]);
		$password = trim($_POST["password"]);
		if (empty($Email) )
		{
			$message = "Please enter both Email and password!";
		}
		else
		{
		    if (($Email == 'admin') && ($password == 'admin123')){	
			$_SESSION['UserId'] = $Email;
			$_SESSION['FirstName'] = "Alexey";
			$_SESSION['LastName'] = "Tregubov";
			if ($Email == 'admin'){	
				$_SESSION['level'] = 1; 
			} else {
				$_SESSION['level'] = 0;
			}
			$_SESSION['Email'] = $Email;
			$_SESSION['Team'] = 8;
			set_session();
			//redirect authenticated user to main page
			header("Location: board.php");
		    }
		    $message = "Incorrect Email or password!";
		}
	}

?>
<?php include("includes/header.php"); ?>

<div class="hero-unit center" id="login-hero">
  <form action="login.php" method="post">
    <fieldset align="center">
      <div id="legend">
        <legend>Login to Your Agile Board</legend>
      </div>
      <div class="control-group">
          <!-- Email -->
          <!-- <label class="control-label"  for="Email">Email</label> -->
          <div class="controls">
            <input type="text" id="Email" name="Email" maxlength="20" placeholder="Email" class="input-xlarge">
          </div>
        </div>
    
        <div class="control-group">
          <!-- Password-->
          <!-- <label class="control-label" for="password">Password</label> -->
          <div class="controls">
            <input type="password" id="password" name="password" placeholder="Password" class="input-xlarge">
          </div>
        </div>
    
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <input type="submit" name="submit" value="Login" class="btn btn-success" />
          </div>
        </div>
    </fieldset>
  </form>
</div>
<?php include('includes/footer.php'); ?>


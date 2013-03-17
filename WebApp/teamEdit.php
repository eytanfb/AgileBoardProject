<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

<?php

	$is_new = true;
	$item_id = -1;	

	if (isset($_POST['update']))
	{
			$query = "UPDATE teams SET team_name='{$_POST['name']}', team_description='{$_POST['description']}' WHERE team_id_pk={$_POST['id']}";
			mysql_query($query, $connection) or die(mysql_error());
			header("Location: teamList.php");
	}
	elseif (isset($_POST['insert']))
	{
			$query = "INSERT teams (team_name,team_description) VALUES ('{$_POST['name']}', '{$_POST['description']}')";
			mysql_query($query, $connection) or die(mysql_error());
			header("Location: teamList.php");
	}
	elseif (isset($_POST['delete']))
	{
			$query = "DELETE FROM teams WHERE team_id_pk={$_POST['id']}";
			mysql_query($query,$connection) or die(mysql_error());
			header("Location: teamList.php");
	}
	elseif (isset($_GET['id']))
	{
		$item_id = $_GET['id'];
		if (is_numeric($item_id) && $item_id>-1 )
		{
			$is_new = false;
			
			//fetch record from db
			$query = "SELECT * FROM teams WHERE team_id_pk={$item_id} LIMIT 1";
			$item_set = mysql_query($query,$connection) or die(mysql_error());
			$item = mysql_fetch_array($item_set);
		}
	}
	echo $item_id;
	
?>

	<script type="text/javascript">
						
		$(document).ready(function(){
			$('#btnSubmit').button();
			$('#btnDelete').button();
			$('#discard').button();
			$("input:not(:submit)").addClass("ui-widget-content");
			$("textarea").addClass("ui-widget-content");	
			
			$('#name').focus(function() {$('#name').addClass("ui-state-highlight");});				
			$('#name').blur(function()  {$('#name').removeClass("ui-state-highlight");});
			
			$('#description').focus(function() {$('#description').addClass("ui-state-highlight");});				
			$('#description').blur(function()  {$('#description').removeClass("ui-state-highlight");});
			
		});
	</script>
			<div id="content">
				<div style="margin:30 auto;width:800px;">
				<form action="teamEdit.php" method="post">
						<fieldset class="ui-widget ui-widget-content ui-corner-all">
						<legend class="ui-widget ui-widget-header ui-corner-all"><?php if($is_new) {echo "Add a New Team";} else {echo "Edit or Delete";} ?></legend>
						<p>
							<div style="float:left;width:100px;"><label for="name">Name:</label></div>
							<input id="name" name="name" type="text" <?php if(!$is_new) { echo "value={$item['team_name']}"; } ?> />
						</p>
						<p>
							<div style="float:left;width:100px;"><label for="description">Description:</label></div>
							<textarea id="description" name="description" rows="2" cols="50"><?php if(!$is_new) { echo $item['team_description']; } ?></textarea>
						</p>	
						<p>
							<input id="btnSubmit" type="submit" name="<?php if(!$is_new) {echo "update";} else {echo "insert";}?>" value="Submit" />							
							<a id="discard" href="teamlist.php">Back</a>						
							<?php if(!$is_new):  ?>
								<input type="hidden" name="id" value="<?php echo $item_id; ?>">
								<input id="btnDelete" type="submit" value="Delete" name="delete">
							<?php endif;?>
						</p>
					</fieldset>					
				</form>
				</div>	
			</div>

<?php include('includes/footer.php')?>
<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

<?php

	$is_new = true;
	$item_id = -1;	
        $users = array();
        $current_team_members = array();

	if (isset($_POST['update']))
	{
			mysql_query("LOCK TABLES teams WRITE, users WRITE, boards WRITE, iterations WRITE;",$connection) or die(mysql_error());
			mysql_query("START TRANSACTION;",$connection) or die(mysql_error());

			$query = "UPDATE teams SET team_name='{$_POST['name']}', team_description='{$_POST['description']}', iteration_length={$_POST['iteration_length']} WHERE team_id_pk={$_POST['id']}";
			mysql_query($query, $connection) or die(mysql_error());

			$query = "DELETE FROM team_users WHERE tu_team_id_pk_fk={$_POST['id']};";
			mysql_query($query, $connection) or die(mysql_error());

			foreach ($_POST['member_ids'] as $v) {
			    $query = "REPLACE INTO team_users (tu_user_id_pk_fk, tu_team_id_pk_fk) VALUES('{$v}', {$_POST['id']});";
			    mysql_query($query, $connection) or die(mysql_error());
			}
			
			$query = "UPDATE boards SET board_name='{$_POST['board_name']}' WHERE bt_id_fk={$_POST['id']};";
			mysql_query($query, $connection) or die(mysql_error());


			mysql_query("COMMIT;",$connection) or die(mysql_error());
			mysql_query("UNLOCK TABLES;",$connection) or die(mysql_error());

			header("Location: teamList.php");
	}
	elseif (isset($_POST['insert']))
	{
			mysql_query("LOCK TABLES teams WRITE, users WRITE, boards WRITE, iterations WRITE;",$connection) or die(mysql_error());
			mysql_query("START TRANSACTION;",$connection) or die(mysql_error());

			$query = "INSERT teams (team_name, team_description, iteration_length) VALUES ('{$_POST['name']}', '{$_POST['description']}', '{$_POST['iteration_length']}')";
			mysql_query($query, $connection) or die(mysql_error());

			$item_set = mysql_query("SELECT MAX(team_id_pk) AS team_id FROM teams", $connection) or die(mysql_error());
			$item = mysql_fetch_array($item_set);
			$team_id = $item['team_id'];

			foreach ($_POST['member_ids'] as $v) {
			    $query = "REPLACE INTO team_users (tu_user_id_pk_fk, tu_team_id_pk_fk) VALUES('{$v}', {$team_id});";
			    mysql_query($query, $connection) or die(mysql_error());
			}
			
			$query = "INSERT INTO boards (bt_id_fk, board_name, board_isArchived) VALUES({$team_id}, '{$_POST['board_name']}', 0);";
			mysql_query($query, $connection) or die(mysql_error());

			$item_set = mysql_query("SELECT MAX(board_id_pk) AS board_id FROM boards", $connection) or die(mysql_error());
			$item = mysql_fetch_array($item_set);
			$board_id = $item['board_id'];

			$query = "INSERT INTO iterations (iteration_start_date, iteration_end_date, ib_id_fk, iteration_isArchived, iteration_number) VALUES(CURRENT_DATE, CURRENT_DATE + INTERVAL {$_POST['iteration_length']} WEEK, {$board_id}, 0, 1)";
			mysql_query($query, $connection) or die(mysql_error());

			mysql_query("COMMIT;",$connection) or die(mysql_error());
			mysql_query("UNLOCK TABLES;",$connection) or die(mysql_error());

			header("Location: teamList.php");
	}
	elseif (isset($_POST['delete']))
	{
			mysql_query("LOCK TABLES teams WRITE, users WRITE, boards WRITE, iterations WRITE;",$connection) or die(mysql_error());
			mysql_query("START TRANSACTION;",$connection) or die(mysql_error());

			$item_set = mysql_query("SELECT DISTINCT board_id_pk AS board_id FROM boards WHERE bt_id_fk={$_POST['id']} LIMIT 1;", $connection) or die(mysql_error());
			$item = mysql_fetch_array($item_set);
			$board_id = $item['board_id'];

			$query = "DELETE FROM iterations WHERE ib_id_fk={$board_id}";
			mysql_query($query,$connection) or die(mysql_error());

			$query = "DELETE FROM boards WHERE board_id_pk={$board_id}";
			mysql_query($query,$connection) or die(mysql_error());

			$query = "DELETE FROM team_users WHERE tu_team_id_pk_fk={$_POST['id']}";
			mysql_query($query,$connection) or die(mysql_error());

			$query = "DELETE FROM teams WHERE team_id_pk={$_POST['id']}";
			mysql_query($query,$connection) or die(mysql_error());

			mysql_query("COMMIT;",$connection) or die(mysql_error());
			mysql_query("UNLOCK TABLES;",$connection) or die(mysql_error());

			header("Location: teamList.php");
	}
	elseif (isset($_GET['id']))
	{
		$item_id = $_GET['id'];
		if (is_numeric($item_id) && $item_id>-1 )
		{
			$is_new = false;
			
			mysql_query("LOCK TABLES teams READ, users READ, boards READ, roles READ, users u READ, team_users READ, team_users tu READ;",$connection) or die(mysql_error());
			//fetch record from db
			$query = "SELECT DISTINCT * FROM teams, boards WHERE teams.team_id_pk=boards.bt_id_fk and teams.team_id_pk={$item_id} LIMIT 1;";
			$item_set = mysql_query($query,$connection) or die(mysql_error());
			$item = mysql_fetch_array($item_set);

            		// show list of users, but only those who's not on the team yet
			$query = "SELECT DISTINCT * FROM users, roles WHERE users.user_id_pk NOT IN (SELECT DISTINCT u.user_id_pk FROM users u, team_users tu WHERE u.user_id_pk=tu.tu_user_id_pk_fk) and users.user_role_fk=roles.role_id_pk AND roles.role_name='user' ORDER BY users.user_last_name;";
			$user_set = mysql_query($query,$connection) or die(mysql_error());
            		$counter = 0;
	 	        while($user = mysql_fetch_array($user_set)) {
    			    $users[$counter]['user_first_name'] = $user['user_first_name'];
    			    $users[$counter]['user_last_name'] = $user['user_last_name'];
	    		    $users[$counter]['user_id'] = $user['user_id_pk'];
        		    $counter++;
                        }

            		// get people already on this team
			$query = "SELECT DISTINCT users.user_id_pk, users.user_first_name, users.user_last_name FROM users, team_users WHERE users.user_id_pk=team_users.tu_user_id_pk_fk AND team_users.tu_team_id_pk_fk={$item_id} ORDER BY users.user_last_name;";
			$user_set = mysql_query($query,$connection) or die(mysql_error());
	                $counter = 0;
                        while($user = mysql_fetch_array($user_set)) {
    			    $current_team_members[$counter]['user_first_name'] = $user['user_first_name'];
    			    $current_team_members[$counter]['user_last_name'] = $user['user_last_name'];
    			    $current_team_members[$counter]['user_id'] = $user['user_id_pk'];
	                    $counter++;
            		}
			mysql_query("UNLOCK TABLES;",$connection) or die(mysql_error());

		} elseif (is_numeric($item_id) && $item_id == -1) {
			mysql_query("LOCK TABLES users READ, roles READ, users u READ, team_users tu READ;",$connection) or die(mysql_error());
			$query = "SELECT DISTINCT * FROM users, roles WHERE users.user_id_pk NOT IN (SELECT DISTINCT u.user_id_pk FROM users u, team_users tu WHERE u.user_id_pk=tu.tu_user_id_pk_fk) and users.user_role_fk=roles.role_id_pk AND roles.role_name='user' ORDER BY users.user_last_name;"; // admins cannot be members of any team
			$user_set = mysql_query($query,$connection) or die(mysql_error());
		        $counter = 0;
            		while($user = mysql_fetch_array($user_set)) {
    			    $users[$counter]['user_first_name'] = $user['user_first_name'];
    			    $users[$counter]['user_last_name'] = $user['user_last_name'];
    			    $users[$counter]['user_id'] = $user['user_id_pk'];
                            $counter++;
                        }
			mysql_query("UNLOCK TABLES;",$connection) or die(mysql_error());
                }
	}
?>

	<script type="text/javascript">

	    function deleteMember(elementID) {
		// add this user back to drop down menu
		$('#user_list').append('<option value="' + $('#' + elementID + '_id').val() + '">' + $('#' + elementID + '_fn').html() + " " + $('#' + elementID + '_ln').html() + '</option>');
		// delete user from "members" table
		$('#' + elementID).remove();
	    }

		$(document).ready(function(){
				$('#btnAdd').button({ icons: {primary:"ui-button ui-icon ui-icon-circle-plus" }});

                $('#team_action_log').dataTable({
                    "bJQueryUI": false,
                    'sScrollY': '200px',
                    "aoColumns": [
                    { "bSortable": true, "bSearchable": false, "sWidth": "600px" },
                    { "bSortable": true, "bSearchable": false, "sWidth": "100px"},
                    ]
                    });


			$("#btnAddTeamMember").click(function() {
			  if($("#user_list").children().length < 1) { // no valid entries...
			    return;	
			  }
			  var fName = $("#user_list option:selected").text().split(' ')[0];
			  var lName = $("#user_list option:selected").text().split(' ')[1];
			  var userID = $("#user_list option:selected").val();
			  if(!userID) { return; }

			  // add this user to "members" table
			  $('#members_table').append('<tr id="tr_' + userID + '"><td id="tr_' + userID + '_fn">' + fName + '</td><td id="tr_' + userID + '_ln">' + lName + '</td><td><a href="#" name="remove_lnk" id="remove_' + userID + '" onClick="deleteMember(\'tr_' + userID + '\');">Remove from Group</a><input type="hidden" id="tr_' + userID + '_id" name="member_ids[]" value="' + userID + '" /></td></tr>')

			  // now delete this entry from the drop down..
			  $("#user_list option:selected").remove();
			});

			$('#btnSubmit').button();
			$('#btnDelete').button();
			$('#btnAddTeamMember').button();
			$('#discard').button();
			$("input:not(:submit)").addClass("ui-widget-content");
			$("textarea").addClass("ui-widget-content");	
			
			$('#name').focus(function() {$('#name').addClass("ui-state-highlight");});				
			$('#name').blur(function()  {$('#name').removeClass("ui-state-highlight");});
			
			$('#description').focus(function() {$('#description').addClass("ui-state-highlight");});				
			$('#description').blur(function()  {$('#description').removeClass("ui-state-highlight");});

            $("#btnDelete").click(function(e){
                if(!confirm("WARNING: Deleting a team will delete all tasks that belong to it. Are you sure you want to continue?")) {
                    return false;
                }
            });
			
		});
	</script>
			<div id="content">
				<div style="margin:30 auto;width:800px;">
					<button id="btnHome" class="btn btn-primary adminButton" type="button" onclick="location.href='teamList.php'">Back to Team Listing's Page</button><br /><br />										
				<form id="myForm" action="teamEdit.php" method="post">
						<fieldset class="ui-widget ui-widget-content ui-corner-all">
						<legend class="ui-widget ui-widget-header ui-corner-all">&nbsp;&nbsp;&nbsp;<?php if($is_new) {echo "Add a New Team";} else {echo "Edit or Delete";} ?></legend>
						<p>
							<div style="float:left;width:200px;"><label for="name">&nbsp;&nbsp;&nbsp;&nbsp;Team Name:</label></div>
							<input id="name" name="name" type="text" <?php if(!$is_new) { echo "value=\"{$item['team_name']}\""; } ?> />
						</p>
						<p>
							<div style="float:left;width:200px;"><label for="description">&nbsp;&nbsp;&nbsp;&nbsp;Description:</label></div>
							<textarea id="description" name="description" rows="2" cols="50"><?php if(!$is_new) { echo $item['team_description']; } ?></textarea>
						</p>	
						<p>
							<div style="float:left;width:200px;"><label for="board_name">&nbsp;&nbsp;&nbsp;&nbsp;Board Name:</label></div>
							<input id="board_name" name="board_name" type="text" <?php if(!$is_new) { echo "value=\"{$item['board_name']}\""; } ?> />
						</p>
						<p>
							<div style="float:left;width:200px;"><label for="iteration_length">&nbsp;&nbsp;&nbsp;&nbsp;Iteration Length (weeks):</label></div>
							<select id="iteration_length" name="iteration_length"> <?php if(!$is_new) { echo "value={$item['team_name']}"; } ?>
							<?php if(!$is_new) { ?>
							    <option value="1" <?php if($item['iteration_length'] == 1) { echo "selected"; } ?>>1</option>
							    <option value="2" <?php if($item['iteration_length'] == 2) { echo "selected"; } ?>>2</option>
							    <option value="3" <?php if($item['iteration_length'] == 3) { echo "selected"; } ?>>3</option>
							    <option value="4" <?php if($item['iteration_length'] == 4) { echo "selected"; } ?>>4</option>
							    <option value="5" <?php if($item['iteration_length'] == 5) { echo "selected"; } ?>>5</option>
							    <option value="6" <?php if($item['iteration_length'] == 6) { echo "selected"; } ?>>6</option>
							    <option value="7" <?php if($item['iteration_length'] == 7) { echo "selected"; } ?>>7</option>
							    <option value="8" <?php if($item['iteration_length'] == 8) { echo "selected"; } ?>>8</option>
							<?php } else { ?>
							    <option value="1" selected>1</option>
							    <option value="2">2</option>
							    <option value="3">3</option>
							    <option value="4">4</option>
							    <option value="5">5</option>
							    <option value="6">6</option>
							    <option value="7">7</option>
							    <option value="8">8</option>
							<?php } ?>
							</select>
						</p>
						<p>
							<div style="float:left;width:200px;"><label for="user_list">&nbsp;&nbsp;&nbsp;&nbsp;Assign Members:</label></div>
                            <select id="user_list" name="user_list">
                                <?php if(count($users) > 0) {
                                    for($i = 0; $i < count($users); $i++) {
                                        echo "<option value=\"" . $users[$i]['user_id'] . "\">" . $users[$i]['user_first_name'] . " " . $users[$i]['user_last_name'] . "</option>";
                                    }
                                  } else {
                                    echo "<option></option>\n";
                                  }
                                 ?>
                            </select>
							<input id="btnAddTeamMember" type="button" name="add" value="Add" />							
						</p>	
						<p>
							<div style="float:left;width:200px;"><label for="description">&nbsp;&nbsp;&nbsp;&nbsp;Members:</label></div>
							<table id="members_table"><tr><th colspan="2">Member</th><th>Options</th></tr>
                                			<?php if(count($current_team_members) > 0) {
							  foreach($current_team_members as $team_member) {
							    echo "<tr id=\"tr_" . $team_member['user_id'] . "\"><td id=\"tr_" . $team_member['user_id'] . "_fn\">";
							    echo $team_member['user_first_name'];
							    echo "</td><td id=\"tr_" . $team_member['user_id'] . "_ln\">";
							    echo $team_member['user_last_name'];
							    echo "</td><td>";
							    echo "<a href=\"#\" name=\"remove_lnk\" id=\"remove_" . $team_member['user_id'] . "\" onClick=\"deleteMember('tr_" . $team_member['user_id'] . "');\">Remove from Group</a>";
							    echo "<input type=\"hidden\" id=\"tr_" . $team_member['user_id'] . "_id\" name=\"member_ids[]\" value=\"" . $team_member['user_id'] . "\" />";
							    echo "</td></tr>";
							  }
                                  			}
                                 			?>
							</table>
						</p>	
						<p>
							&nbsp;&nbsp;&nbsp;&nbsp;<input id="btnSubmit" type="submit" name="<?php if(!$is_new) {echo "update";} else {echo "insert";}?>" value="Submit" />							
							<a id="discard" href="teamList.php">Back</a>						
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


<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

<?php
	$is_new = true;
	$item_id = $_GET['id'];	
?>

	<script type="text/javascript">
		$(document).ready(function(){
				$('#btnAdd').button({ icons: {primary:"ui-button ui-icon ui-icon-circle-plus" }});

                $('#team_action_log').dataTable({
                    "bJQueryUI": false,
                    'sScrollY': '200px',
                    "aoColumns": [
                    { "bSortable": true, "bSearchable": true, "sWidth": "600px" },
                    { "bSortable": true, "bSearchable": false, "sWidth": "100px"},
                    ]
                    });
		});
	</script>
			<div id="content">
				<div style="margin:30 auto;width:800px;">

                <div>

					<button id="btnHome" class="btn btn-primary adminButton" type="button" onclick="location.href='teamList.php'">Back to Team Listing's Page</button><br /><br />										

				    <fieldset class="ui-widget ui-widget-content ui-corner-all">
						<legend class="ui-widget ui-widget-header ui-corner-all">&nbsp;&nbsp;&nbsp;Team's History Log</legend>
                        <table id="team_action_log">
						<thead>
							<tr>
								<th>Action</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$query = "SELECT DISTINCT * FROM task_action_log WHERE tal_user_id_fk IN (SELECT DISTINCT team_users.tu_user_id_pk_fk FROM teams, team_users WHERE teams.team_id_pk=team_users.tu_team_id_pk_fk AND teams.team_id_pk='{$item_id}') ORDER BY tal_date DESC";
								$items = mysql_query($query,$connection) or die(mysql_error());
								while ($item = mysql_fetch_array($items))
								{									
									echo "<tr><td>";
                                    if ($item['tal_change_type_id_fk'] == 1) { // create task
                                        echo "{$item['tal_user_id_fk']} created new task #{$item['tal_task_id_fk']} ({$item['tal_old_attribute_value']})";
                                    } else if ($item['tal_change_type_id_fk'] == 2) { // updated task
                                        echo "{$item['tal_user_id_fk']} updated task #{$item['tal_task_id_fk']} ({$item['tal_old_attribute_value']})";
                                    } else if ($item['tal_change_type_id_fk'] == 3) { // deleted task
                                        echo "{$item['tal_user_id_fk']} deleted task #{$item['tal_task_id_fk']} ({$item['tal_old_attribute_value']})";
                                    } else if ($item['tal_change_type_id_fk'] == 4) { // updated status
                                        echo "{$item['tal_user_id_fk']} updated status of task #{$item['tal_task_id_fk']} ({$item['tal_old_attribute_value']}) {$item['tal_new_attribute_value']}";
                                    }
                                    echo "</td><td>{$item['tal_date']}</td>
										</tr>";
								}
							?>													
						</tbody>
					</table>

                    </fieldset>
                </div>

				</div>	
			</div>

<?php include('includes/footer.php')?>


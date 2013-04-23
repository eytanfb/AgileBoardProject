<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

	
		
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				
				$('#btnHome').button({ icons: {primary:"ui-icon-arrowthick-1-w" }});
				
				
				
				$('#gridTeams').dataTable({
					"bJQueryUI": true,
					'sScrollY': '300px',
					"aoColumns": [
				                    { "bSortable": true, "bSearchable": true, "sWidth": "200px" },
				                    { "bSortable": true, "bSearchable": true, "sWidth": "500px"},
									{ "bSortable": false, "bSearchable": false, "sWidth": "50px"},				
									{ "bSortable": false, "bSearchable": false, "sWidth": "50px"}				
								 ]
					});
			} );
		</script>
		</script>

			<div id="content">
				<div style="width:800px;margin: 30px auto;">
					<p>
						<button id="btnHome" class="btn btn-primary adminButton" type="button" onclick="location.href='board.php'">Back to Board Page</button>
						<h1 style='color:#C41E3A'>Team Iteration History</h1>
					</p>																				
					<ul>
					<?php
						$query = "SELECT DISTINCT  iteration_id_pk, iteration_number, iteration_start_date, iteration_end_date FROM users LEFT JOIN team_users ON ( team_users.tu_user_id_pk_fk = users.user_id_pk ) LEFT JOIN teams ON (teams.team_id_pk=team_users.tu_team_id_pk_fk) LEFT JOIN boards ON ( boards.bt_id_fk=team_users.tu_team_id_pk_fk ) LEFT JOIN iterations ON ( iterations.ib_id_fk=boards.board_id_pk ) WHERE ( users.user_login = '{$_SESSION['Email']}') ORDER BY iterations.iteration_start_date ASC";
						$result_set = mysql_query($query,$connection) or die(mysql_error());
						
						while( $item = mysql_fetch_array($result_set))
						{
							echo '<li class="ui-state-default ui-corner-all" style="margin-top:7px;list-style:none;">';
							echo '<span style="color:maroon">' . '#' . $item['iteration_number']  . ' : From ' . $item['iteration_start_date'] . ' To ' . $item['iteration_end_date'] . '</span>';
							
							echo '<ul>';
							$query2 = "SELECT * FROM tasks WHERE ti_id_fk=" . $item['iteration_id_pk'] ;
							$result_set2 = mysql_query($query2);							
							while ($item2 = mysql_fetch_array($result_set2))
							{
								echo '<li>';
								echo  '<span class="t">' . $item2['task_name'] . '</span>' . ': ' . $item2['task_description'] . ' <span style="color:black">(' . $item2['taks_responsible_person_fk'] . '</span>)';
								echo '</li>';
							}
							echo '</ul>';
							echo '</li>';
						}
					?>
					<ul>
				<div>
			</div>

<?php include('includes/footer.php')?>

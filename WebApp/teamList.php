<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

	
		
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				
				$('#btnAdd').button({ icons: {primary:"ui-button ui-icon ui-icon-circle-plus" }});
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
					<button id="btnHome" class="btn btn-primary adminButton" type="button" onclick="location.href='board.php'">Back to Board Page</button>										
					<button id="btnAdd" class="btn btn-primary adminButton" type="button" onclick="location.href='teamEdit.php?id=-1'">Add A New Team</button><br /><br />					
					<table id="gridTeams">
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$query = "SELECT * FROM teams";
								$items = mysql_query($query,$connection) or die(mysql_error());
								while ($item = mysql_fetch_array($items))
								{									
									echo "<tr>
										 	<td>{$item['team_name']}</td>
											<td>{$item['team_description']}</td>
											<td><a href='teamEdit.php?id={$item['team_id_pk']}'>Edit</a></td>
											<td><a href='teamHistory.php?id={$item['team_id_pk']}'>History</a></td>
										</tr>";
								}
							?>													
						</tbody>
					</table>
				<div>
			</div>

<?php include('includes/footer.php')?>

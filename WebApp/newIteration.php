<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

<?php

	
	if (isset($_POST['insert']))
	{
			//Archive pervious iterations
			$query = "UPDATE iterations SET iteration_isArchived=1 WHERE iteration_id_pk='{$_SESSION['iteration_id']}'";
			mysql_query($query, $connection) or die(mysql_error());
			
			//Insert a new iterations
			$query = "INSERT iterations (iteration_number, iteration_start_date, iteration_end_date, iteration_isArchived, ib_id_fk) VALUES ('{$_POST['number']}', '{$_POST['startDate']}','{$_POST['endDate']}', 0, '{$_SESSION['board_id']}')";
			mysql_query($query, $connection) or die(mysql_error());
			
			//Move uncomplete tasks from pervious iteraton to new one
			$newIterationId = mysql_insert_id();
			$query= "UPDATE tasks LEFT JOIN iterations ON (tasks.ti_id_fk=iterations.iteration_id_pk) SET tasks.ti_id_fk='{$newIterationId}', ts_id_fk='TODO' WHERE iterations.ib_id_fk = '{$_SESSION['board_id']}' AND tasks.ts_id_fk !='DONE'";			
			mysql_query($query, $connection) or die(mysql_error());
			
			header("Location: logout.php");
	}
	
?>

	<script type="text/javascript">
						
		$(document).ready(function(){
			$('#btnSubmit').button();
			$('#discard').button();
			$("input:not(:submit)").addClass("ui-widget-content");
			
			$('#startDate').datepicker({
				// defaultDate: "+1w",
				changeMonth: true,
				dateFormat: "yy-mm-dd",
				numberOfMonths: 2,
				onClose: function( selectedDate ) {
				        $( "#endDate" ).datepicker( "option", "minDate", selectedDate );
					}
			});
			
			$('#endDate').datepicker({
				// defaultDate: "+1w",
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				numberOfMonths: 2,
				onClose: function( selectedDate ) {
				        $( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
						}
			});
			
			$('#number').focus(function() {$('#number').addClass("ui-state-highlight");});				
			$('#number').blur(function()  {$('#number').removeClass("ui-state-highlight");});
			
				$('#gridTask').dataTable({
					"bJQueryUI": true,
					"bFilter": false,
					"bInfo" : false,
					'sScrollY': '300px',
					"aoColumns": [
				                    { "bSortable": false, "bSearchable": false, "sWidth": "300px" },
								    { "bSortable": false, "bSearchable": false, "sWidth": "400px" },
	                    			{ "bSortable": false, "bSearchable": false, "sWidth": "170px" },
									{ "bSortable": false, "bSearchable": false, "sWidth": "170px"}				
								 ]
					});
						
		});
	</script>
			<div id="content">
				<div style="margin:30 auto;width:800px;">
				<form action="newIteration.php" method="post">
						<fieldset class="ui-widget ui-widget-content ui-corner-all">
						<legend class="ui-widget ui-widget-header ui-corner-all">Add a new Iteration</legend>
						<p>
							<div style="float:left;width:100px;"><label for="number">Number:</label></div>
							<input id="number" name="number" type="text" />
						</p>
						<p>
							<div style="float:left;width:100px;"><label for="startDate">Date:</label></div>
							Form <input id="startDate" name="startDate" type="text" />
							 To <input id="endDate" name="endDate" type="text" />
						</p>
						<p>
							<div>By creating this new iteration current uncompleted tasks move to ToDo column of new iteration</div>
						</p>
						<p>
							<table id="gridTask">
								<thead>
									<tr>
										<th>Name</th>
										<th>Description</th>
										<th>Work Estimation</th>
										<th>Current Status</th>										
									</tr>
								</thead>
								<tbody>
								<?php 
										$squery= "SELECT * FROM tasks LEFT JOIN iterations ON (tasks.ti_id_fk=iterations.iteration_id_pk) WHERE iterations.ib_id_fk =  '{$_SESSION['board_id']}' AND tasks.ts_id_fk !='DONE'";
										$sitems = mysql_query($squery);
										while ($item = mysql_fetch_array($sitems))
										{
											echo "<tr>
												 	<td>{$item['task_name']}</td>
													<td>{$item['task_description']}</td>
													<td>{$item['task_work_estimation']}</td>																										
													<td>{$item['ts_id_fk']}</td>													
												</tr>";
										}
								?>
								</tbody>
							</table>
						</p>
						<p>				
							<div>After submit information for updating session you should login again!</div>
						</p>
						<p>
							<input id="btnSubmit" type="submit" name="insert" value="Submit" />							
							<a id="discard" href="board.php">Cancel</a>						
						</p>
					</fieldset>					
				</form>
				</div>	
			</div>

<?php include('includes/footer.php')?>
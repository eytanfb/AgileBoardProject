<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

<?php

	
	if (isset($_POST['insert']))
	{
			$query = "INSERT iterations (iteration_number, iteration_start_date, iteration_end_date, iteration_isArchived, ib_id_fk) VALUES ('{$_POST['number']}', '{$_POST['startDate']}','{$_POST['endDate']}', 0, 0)";
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
							Please be careful by create a new iteration all your To Do and Doing task in current iteration is moving to To Do in this iteration!
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
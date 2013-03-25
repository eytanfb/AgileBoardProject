<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

<style>

	.column { 
		width: 33%;
		height:100%; 
		float: left; 
		margin:1px;
		border:1px solid black;
	}
	
	.column-header{
		width:100%;
		color:maroon;
		font:Times;
		font-size:20pt;
		font-weight:bold;
		text-align:center;
		margin:0px;
	}
		
	.ui-sortable-placeholder { 
		border: 1px dotted black; 
		visibility: visible !important; 
		height: 110px !important; 
	}

  .ui-sortable-placeholder * { visibility: hidden; }
 
	
	.portlet { 
		width:120px;
		height:120px;
	}
	
	.portlet-container{
		background-color:yellow;
		border:1px solid maroon;
	}
	  
	.taskContainer{
		width:100%;
		height:100%;
		padding:2px;
	}
	
	.taskContainer li{
		float:left;
		list-style: none;
		margin:0 5px;
	}
	
	input[id*="task"] {
		border:0px;
		color:black;
		background-color:yellow;
		width:110px;
		height:20px;
		margin-left:3px;
		font-family:"Comic Sans MS";
		font-size:10pt;
	}
	
/*	for combo*/
  		.ui-combobox {
    		position: relative;
    		display: inline-block;
  		}
  		.ui-combobox-toggle {
    		position: absolute;
    		top: 0;
    		bottom: 0;
    		margin-left: -1px;
    		padding: 0;
    		/* support: IE7 */
    		*height: 1.7em;
    		*top: 0.1em;
  		}
  		.ui-combobox-input {
    		margin: 0;
    		padding: 0.3em;
  		}

</style>

<script type="text/javascript">

	<?php

		$query = "SELECT task_id_pk, task_name, task_description, task_work_estimation, taks_responsible_person_fk FROM tasks";
		$items = mysql_query($query);
		$data = array();
		while( $item = mysql_fetch_array($items) )
		{
			$data[] = $item;
		}

		$jsonData = json_encode($data);
		echo "var boardData = {$jsonData}"

	?>

		var taskTemplate =  "<li class='portlet'> \
			    					<div class='portlet-container'> \
			 		   					<div class='ui-icon ui-icon-arrow-4-diag' style='float:left'></div> <div style='float:right'><a class='ui-icon ui-icon-trash' href='#' onclick='deleteTask($(this))'></a></div> \
			 							<input id='taskId' name='taskId' type='hidden' value='[taskIdVal]' > \
					    				<input id='taskName' name='taskName' type='text' placeholder='Task Name' value='[taskNameVal]'> \
	 									<input id='taskDesc' name='taskDesc' type='text' placeholder='Task Desc' value='[taskDesc]'> \
	 									<input id='taskEstimate' name='taskEstimate' type='text' placeholder='Task Estimate (hour)' value='[taskEstimateVal]' > \
	 									<input id='taskResponsibleName' name='taskResponsibleName' type='text' placeholder='Task Responsible' value='[taskResponsibleNameVal]' > \
										<input id='taskResponsibleId' name='taskResponsibleId' type='hidden' value='[taskResponsibleIdVal]' > \
	 	   							</div>  \
	  						</li>";

	function drawBoard()
	{
		for each (task in boardData)
		{
			//draw task;
			var t = taskTemplate;
			t = t.replace('[taskIdVal]',task['task_id_pk']);
			t = t.replace('[taskNameVal]',task['task_name']);
			t = t.replace('[taskDesc]',task['task_description']);
			t = t.replace('[taskEstimateVal]',task['task_work_estimation']);
			t = t.replace('[taskResponsibleIdVal]',task['taks_responsible_person_fk']);
			
			$('#toDo').append(t);			
		}
	}	
	
	//delete task
	function deleteTask(item)
	{
		deleteTaskId = item.parent().parent().parent().find('#taskId').val();
				
		 if (taskId != -1)
		 {
			//remove from DB
			$.post('saveBoard.php', {"action":"delete","task_id_pk":deleteTaskId}, function(data){ console.log(data)});	
		 }
		
		item.parent().parent().parent().first().remove();
	}
	
	//Save (insert & update) task
	function saveTask(){			
		d =  {
			"action":"submit",
			"task_id_pk" : $(this).find('#taskId').val(),
			"task_name"  : $(this).find('#taskName').val(),
		    "task_description" :  $(this).find('#taskDesc').val(),
			"task_creator_id_fk" :  "",
			"taks_responsible_person_fk" : $(this).find('#taskResponsibleId').val(),
			"task_work_estimation" : $(this).find('#taskEstimate').val(),		
			"ti_id_fk":  $(this).parent().attr('id').toUpperCase()				
		 };				
		$.post('saveBoard.php', d, function(data){ console.log(data)});
	}
	
						
	$(function() {
		
		$('#addNewTask').button({icons:{primary:"ui-icon-document"}});
		$('#saveBoard').button({icons:{primary:"ui-icon-disk"}});
		$("#iterationSelector").combobox();	
	
			
		//load board
		drawBoard();
			
		//Save board		
		$('#saveBoard').click(function() {			
			$('#toDo li').each(	saveTask );
		});
			 		
		
		$('.taskContainer').sortable({
			connectWith: ".taskContainer"
		});		
		
		$( ".portlet-container" ).addClass( "ui-widget ui-helper-clearfix ui-corner-all" );
		
		// $( ".taskContainer" ).disableSelection();
		

		
		
		$('#addNewTask').click(function(){
			
			var t = taskTemplate;
			t = t.replace('[taskIdVal]', '-1');
			t = t.replace('[taskNameVal]','');
			t = t.replace('[taskDesc]','');
			t = t.replace('[taskEstimateVal]','');
			t = t.replace('[taskResponsibleNameVal]','');
			t = t.replace('[taskResponsibleIdVal]','-1');

			$('#toDo').append(t);
			
		});															
			
					
	});					
	 

</script>

			<div id="content" style="width:80%;height:90%">
				
				<div style="clear:both;">

						<button id="addNewTask">Add a New Task</button>

						
						<select id="iterationSelector" name="iterationID" style="display:none;">
							<?php
								$squery= "SELECT * FROM iterations order by iteration_start_date desc "; //$_SESSION['team_num']
								$sitems = mysql_query($query) or dire (mysql_error());
								while ( $sitem = mysql_fetch_array($sitems) )
								{
									echo "<option value='1'> {$sitem['iteration_number']} : {$sitem['iteration_start_date']} - {$sitem['iteration_end_date']}  </option>";
								}
							?>
						</select>

					<div style="float:right">
						<button id="saveBoard">Save Board</button>
					</div>
					
				</div>			
				
				<div class="column">
						<div class='column-header'>To Do</div>
						<ul id="toDo" class="taskContainer">																	
						</ul>							
				</div>
				
				<div class="column">					
						<div class='column-header'>Doing</div>					
						<ul id="doing" class="taskContainer">
						</ul>
				</div>
				
				<div class="column">
						<div class='column-header'>Done</div>					
						<ul id="done" class="taskContainer">
						</ul>					
				</div>
					
			</div>

<?php include('includes/footer.php')?>
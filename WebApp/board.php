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
		width:150px;
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
	
	input[id*="task"] , select, option{
		border:0px;
		color:black;
		background-color:yellow;
		width:145px;
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

		$query = "SELECT task_id_pk, task_name, task_description, task_work_estimation, taks_responsible_person_fk, ts_id_fk FROM tasks";
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
										<select id='taskReponsibleUser' name='reponsibleUser'>[UserList_PLACEHOLDER]</select> \
	 	   							</div>  \
	  						</li>";
	var userListItem =  <?php
							echo '"'. "<option value='-1'>Task Responsible</option>";
							$queryu = "SELECT users.user_id_pk, users.user_login, users.user_first_name, users.user_last_name FROM team_users LEFT JOIN users ON users.user_id_pk=team_users.tu_user_id_pk_fk WHERE team_users.tu_team_id_pk_fk='{$_SESSION['team_num']}'";
							$itemsu = mysql_query($queryu) or die(mysql_error());
							while ($itemu = mysql_fetch_array($itemsu))
							{
								echo   "<option value='{$itemu['user_id_pk']}'>{$itemu['user_first_name']} {$itemu['user_last_name']}</option>";
							}
							echo '";';							
						?>
		taskTemplate = taskTemplate.replace('[UserList_PLACEHOLDER]',userListItem);
	
	

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
			t = t.replace("<option value='" + task['taks_responsible_person_fk'] + "'>" ,"<option value='" + task['taks_responsible_person_fk'] + "' selected >");
			$('#'+ task['ts_id_fk'].toLowerCase()).append(t);			
		}
	}	
	
	//delete task
	function deleteTask(item)
	{
		deleteTaskId = item.parent().parent().parent().find('#taskId').val();
				
		 if (taskId != -1)
		 {
			//remove from DB
			$.post('saveBoard.php', {"action":"delete","task_id_pk":deleteTaskId}, function(data){});	
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
			"task_creator_id_fk" : <?php  echo $_SESSION['user_id'] ?>,
			"taks_responsible_person_fk" : $(this).find('#taskReponsibleUser').find(':selected').val(),
			"task_work_estimation" : $(this).find('#taskEstimate').val(),		
			"ts_id_fk":  $(this).parent().attr('id').toUpperCase()				
		 };	

		$.ajax({
			type: 'POST',
			url: 'saveBoard.php',
			data: d,
			async:false,
			success : function(data){ }			
		});
	}
	
						
	$(function() {
		
		$('#addNewTask').button({icons:{primary:"ui-icon-document"}});
		$('#saveBoard').button({icons:{primary:"ui-icon-disk"}});
		$("#iterationSelector").combobox();	
		$('#iterationSelector_searhtxt').css('width','500px');
	
			
		//load board
		drawBoard();
			
		//Save board		
		$('#saveBoard').click(function() {			
			$('#todo li').each(saveTask );
			$('#doing li').each(saveTask );
			$('#done li').each(	saveTask );
			
			window.location.href = 'board.php';
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

			$('#todo').append(t);
			
		});															
			
					
	});					
	 

</script>

			<div id="content" style="width:80%;height:90%">
				
				<div style="clear:both;">

						<button id="addNewTask">Add a New Task</button>

						
						<select id="iterationSelector" name="iterationID" style="display:none;">
							<?php
								$squery= "SELECT b.board_name, s.iteration_id_pk, s.iteration_number, s.iteration_start_date, s.iteration_end_date FROM iterations as s LEFT JOIN boards as b ON s.ib_id_fk=b.board_id_pk WHERE b.bt_id_fk= '{$_SESSION['team_num']}' order by iteration_start_date desc ";
								$sitems = mysql_query($squery) or dire (mysql_error());
								while ( $sitem = mysql_fetch_array($sitems) )
								{
									echo "<option value='{$sitem['iteration_id_pk']}'>  {$sitem['board_name']} > {$sitem['iteration_number']} : {$sitem['iteration_start_date']} - {$sitem['iteration_end_date']}  </option>";
								}
							?>
						</select>

					<div style="float:right">
						<button id="saveBoard">Save Board</button>
					</div>
					
				</div>			
				
				<div class="column">
						<div class='column-header'>To Do</div>
						<ul id="todo" class="taskContainer">																	
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
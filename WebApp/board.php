<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php
    if (isset($_GET['iterationID']) && $_GET['iterationID'] != '-1')
    {
        update_session_foradmin($_GET['iterationID']);
    }
?>
<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php') ?>

<style>

	.column { 
		width: 33%;
		height: 88%; 
		float: left; 
		margin:5px 1px;
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
		height: 100px !important; 
	}

  .ui-sortable-placeholder * { visibility: hidden; }
 
	
	.portlet { 
		width:170px;
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
		width:165px;
		height:20px;
		margin-left:3px;
		font-family:"Comic Sans MS";
		font-size:10pt;
	}
	
	#iterationSelector, #iterationSelector option{
		background-color:white;		
		height:23px;	
		width:450px;
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
		$query = "SELECT task_id_pk, task_name, task_description, task_work_estimation, taks_responsible_person_fk, ts_id_fk FROM tasks WHERE ti_id_fk='{$_SESSION['iteration_id']}' ";
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
							$queryu = "SELECT users.user_id_pk, users.user_login, users.user_first_name, users.user_last_name FROM team_users LEFT JOIN users ON users.user_id_pk=team_users.tu_user_id_pk_fk WHERE team_users.tu_team_id_pk_fk='{$_SESSION['team_id']}'";
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

		// for each (task in boardData)
		for (var i=0; i<boardData.length; i++)
		{
			var task = boardData[i];
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
        if (!confirm('Are you sure you want to delete this task?')) {
            return;
        } 

        deleteTaskId = item.parent().parent().parent().find('#taskId').val();
				
		 if (taskId != -1)
		 {
			//remove from DB
			$.post('saveBoard.php', {
                    "action":"delete",
                    "task_id_pk":deleteTaskId, 
                    "task_creator_id_fk" : '<?php  echo $_SESSION['UserId'] ?>',
                    "task_name"  : item.parent().parent().parent().find('#taskName').val()
            }, function(data){});	
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
			"task_creator_id_fk" : '<?php  echo $_SESSION['UserId'] ?>',
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
				
		$('#newIteration').button({icons:{primary:"ui-icon-document"}}).click(function(){ location.href='newIteration.php';});
		$('#iterationhistory').button({icons:{primary:"ui-icon-document"}}).click(function(){ location.href='iterationhistory.php';});		
		$('#addNewTask').button({icons:{primary:"ui-icon-document"}});
		$('#saveBoard').button({icons:{primary:"ui-icon-disk"}});
		$('#manageTeam').button({icons:{primary:"ui-icon-wrench"}});
		
		// $("#iterationSelector").combobox();	
		// $('#iterationSelector_searhtxt').css('width','500px');
	
			
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

	<div id="content">
				
				<div style="clear:both;width:100%;">
						
							<?Php
								//User
								if (($_SESSION['user_role'] == 0) && ($_SESSION['team_id'] != "")):
								?>
                <div class="navbar">
                  <div class="navbar-inner">
                    <a class="brand" href="board.php"><i class="icon-table"></i>Agile Board</a> <!-- Add Link to actual board -->
                    <ul class="nav">
                      <li id="addNewTask"><a href="#"><i class="icon-pencil"></i>Add a New Task</a></li>
                      <li id="saveBoard"><a href="#"><i class="icon-save"></i>Save Board</a></li>
                      <li id="newIteration"><a href="#"><i class="icon-calendar"></i>Create a New Iteration</a></li>
                      <li id="iterationhistory"><a href="#"><i class="icon-flag"></i>Iteration History</a></li>
                    </ul>
                    <!-- <button id="addNewTask">Add a New Task</button>
                    <button id="saveBoard">Save Board</button>
                    <button id="newIteration">Create a New Iteration</button> -->
                  </div>
                </div>
							<?php endif;?>							
							<?Php
								//Administrator								
								if ($_SESSION['user_role'] == 1):
								?>
									<form name="frmIterationVal" action="board.php" method="GET" style="display: inline">
										<select id="iterationSelector" name="iterationID" onchange="document.forms['frmIterationVal'].submit();">
											<option value='-1'>Please select the board with the latest iteration ...</option>
									<?php
										$squery= "SELECT * FROM boards LEFT JOIN iterations ON ( iterations.ib_id_fk=boards.board_id_pk ) WHERE iterations.iteration_isArchived = 0";
										$sitems = mysql_query($squery) or dire (mysql_error());
										while ( $sitem = mysql_fetch_array($sitems) )
										{											
											$selectVal =   $sitem['board_name'] . ' - ' . $sitem['iteration_number'] . ' : (' . $sitem['iteration_start_date'] . ' - ' . $sitem['iteration_end_date'] . ' )';
											if ( isset($_GET['iterationID']) && $_GET['iterationID'] == $sitem['iteration_id_pk'] )
											{
												echo "<option value='{$sitem['iteration_id_pk']}' selected>{$selectVal}</option>";
											}
											else
											{
												echo "<option value='{$sitem['iteration_id_pk']}'>{$selectVal}</option>";												
											}
										}
									?>
										</select>
								</form>
								<button class="btn btn-primary adminButton" id="manageTeam" onclick="javascript:location.href='teamList.php'">Manage Teams</button>								
							<?php endif;?>					
				</div>	
										
				
				<div class="column ui-widget  ui-corner-all" >
						<div class='column-header'>To Do</div>
						<ul id="todo" class="taskContainer">																	
						</ul>							
				</div>
				
				<div class="column ui-widget  ui-corner-all">					
						<div class='column-header'>Doing</div>					
						<ul id="doing" class="taskContainer">
						</ul>
				</div>
				
				<div class="column ui-widget  ui-corner-all">
						<div class='column-header'>Done</div>					
						<ul id="done" class="taskContainer">
						</ul>					
				</div>
									
			</div>

<?php include('includes/footer.php')?>

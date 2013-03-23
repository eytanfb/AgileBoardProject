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
		font-family:Serif;
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

	$(function() {
		
		$('#addNewTask').button({icons:{primary:"ui-icon-document"}});
		$('#reloadBoard').button({icons:{primary:"ui-icon-refresh"}});
		$('#saveBoard').button({icons:{primary:"ui-icon-disk"}});
		$("#iterationSelector").combobox();	
	
			 		
		
		$('.taskContainer').sortable({
			connectWith: ".taskContainer"
		});		
		
		$( ".portlet-container" ).addClass( "ui-widget ui-helper-clearfix ui-corner-all" );
		
		// $( ".taskContainer" ).disableSelection();
		

		$('#saveBoard').click(function() {

		});
		
		$('#addNewTask').click(function(){

			$('#toDo').append(taskTemplate);
			
		});
		
		var taskTemplate =  "<li class='portlet'>";							
			taskTemplate +=    "<div class='portlet-container'>";
			taskTemplate += 		   "<span class='ui-icon ui-icon-arrow-4-diag'></span>";
			taskTemplate += 			"<input id='taskId' name='taskId' type='hidden' >";
			taskTemplate += 			"<input id='taskName' name='taskName' type='text' placeholder='Task Name'>";
			taskTemplate += 			"<input id='taskDesc' name='taskDesc' type='text' placeholder='Task Desc'>";
			taskTemplate += 			"<input id='taskEstimate' name='taskEstimate' type='text' placeholder='Task Estimate (hour)' >";
			taskTemplate += 			"<input id='taskResponsible' name='taskResponsible' type='text' placeholder='Task Responsible' >";		
			taskTemplate += 	   "</div>"
			taskTemplate +=  "</li>";												
		
	});
	
	 

</script>

			<div id="content" style="width:80%;height:90%">
				
				<div style="clear:both;">

						<button id="addNewTask">Add a New Task</button>

						
						<select id="iterationSelector" name="iterationID" style="display:none;">
							<option value="1">Iteration : 1</option>
							<option value="2">Iteration : 2</option>
							<option value="3">Iteration : 3</option>												
						</select>

					<div style="float:right">
						<button id="reloadBoard">Reload Board</button>
						<button id="saveBoard">Save Board</button>
					</div>
					
				</div>			
				
				<div class="column">						
						<ul id="toDo" class="taskContainer">																	
						</ul>							
				</div>
				
				<div class="column">					
						<ul id="doing" class="taskContainer">
						</ul>
				</div>
				
				<div class="column">
						<ul id="done" class="taskContainer">
						</ul>					
				</div>
					
			</div>

<?php include('includes/footer.php')?>
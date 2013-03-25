<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php
	if ( isset($_POST['action']) && $_POST['action'] == "submit" )
	{
		$query ='';
	 	if ($_POST['task_id_pk'] == -1)
		{
			//New
			$query = "INSERT INTO tasks (task_name, task_description, task_creator_id_fk, taks_responsible_person_fk, task_work_estimation, ts_id_fk) VALUES ('{$_POST['task_name']}', '{$_POST['task_description']}', '{$_POST['task_creator_id_fk']}', '{$_POST['taks_responsible_person_fk']}', '{$_POST['task_work_estimation']}', '{$_POST['ts_id_fk']}')";
			mysql_query($query);
			echo mysql_insert_id();
		}
		else
		{
			//Update
			$query = "UPDATE tasks SET task_name='{$_POST['task_name']}', task_description='{$_POST['task_description']}', task_creator_id_fk='{$_POST['task_creator_id_fk']}', taks_responsible_person_fk='{$_POST['taks_responsible_person_fk']}', task_work_estimation='{$_POST['task_work_estimation']}', ts_id_fk= '{$_POST['ts_id_fk']}' WHERE  task_id_pk='{$_POST['task_id_pk']}'";
			mysql_query($query);
			echo $_POST['task_id_pk'];
		}
		
	}
	
	if ( isset($_POST['action']) && $_POST['action'] == "delete" ){
		$query = "DELETE FROM tasks WHERE task_id_pk='{$_POST['task_id_pk']}'";
		mysql_query($query);
		echo "DONE Delete";		
	}
	

	
?>

<?php include('includes/footer.php')?>

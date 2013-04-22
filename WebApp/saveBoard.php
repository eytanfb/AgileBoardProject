<?php require_once('includes/session.php'); ?>
<?php check_authentication(); ?>
<?php require_once('includes/connection.php') ?>

<?php
	if ( isset($_POST['action']) && $_POST['action'] == "submit" )
	{
		$query ='';
        $task_id = -1;
	 	if ($_POST['task_id_pk'] == -1)
		{
			//New
			$query = "INSERT INTO tasks (task_name, task_description, task_creator_id_fk, taks_responsible_person_fk, task_work_estimation, ts_id_fk, ti_id_fk) VALUES ('{$_POST['task_name']}', '{$_POST['task_description']}', '{$_POST['task_creator_id_fk']}', '{$_POST['taks_responsible_person_fk']}', '{$_POST['task_work_estimation']}', '{$_POST['ts_id_fk']}', '{$_SESSION['iteration_id']}')";
			mysql_query($query);
//			echo mysql_insert_id();
            $task_id = mysql_insert_id();
            $query = "INSERT INTO task_action_log (tal_user_id_fk, tal_date, tal_change_type_id_fk, tal_task_id_fk, tal_old_attribute_value, tal_new_attribute_value) VALUES('{$_POST['task_creator_id_fk']}', CURRENT_DATE, 1, '{$task_id}', '{$_POST['task_name']}', '')";
			mysql_query($query);
		}
		else
        {
            //Update
            mysqli_query($connectioni, "LOCK TABLES tasks t READ, tasks WRITE, task_action_log WRITE;");

            // get values before update for comparison
            $query = "SELECT t.* FROM tasks t WHERE t.task_id_pk = '{$_POST['task_id_pk']}' LIMIT 1";
            $result = mysqli_query($connectioni, $query);
            $row = mysqli_fetch_assoc($result);

            // update task
            $query = "UPDATE tasks SET task_name='{$_POST['task_name']}', task_description='{$_POST['task_description']}', task_creator_id_fk='{$_POST['task_creator_id_fk']}', taks_responsible_person_fk='{$_POST['taks_responsible_person_fk']}', task_work_estimation='{$_POST['task_work_estimation']}', ts_id_fk= '{$_POST['ts_id_fk']}', ti_id_fk='{$_SESSION['iteration_id']}' WHERE  task_id_pk='{$_POST['task_id_pk']}'";
            mysqli_query($connectioni, $query);
            echo $_POST['task_id_pk'];
            $task_id = $_POST['task_id_pk'];

            // nothing changed, don't create task log entry yet
            if ($row['task_name'] == $_POST['task_name'] && $row['task_description'] == $_POST['task_description'] && $row['taks_responsible_person_fk'] == $_POST['taks_responsible_person_fk'] && $row['task_work_estimation'] == $_POST['task_work_estimation']) {
                // no changes so far, check if task status changed
                if ($row['ts_id_fk'] != $_POST['ts_id_fk']) { // task status changed
                    $query = "INSERT INTO task_action_log (tal_user_id_fk, tal_date, tal_change_type_id_fk, tal_task_id_fk, tal_old_attribute_value, tal_new_attribute_value) VALUES('{$_POST['task_creator_id_fk']}', CURRENT_DATE, 4, '{$task_id}', '{$_POST['task_name']}', 'from {$row['ts_id_fk']} to {$_POST['ts_id_fk']}')";
                    mysqli_query($connectioni, $query);
                }
            } else { // something changed, make sure to log it
                $query = "INSERT INTO task_action_log (tal_user_id_fk, tal_date, tal_change_type_id_fk, tal_task_id_fk, tal_old_attribute_value, tal_new_attribute_value) VALUES('{$_POST['task_creator_id_fk']}', CURRENT_DATE, 2, '{$task_id}', '{$_POST['task_name']}', '')";
                mysqli_query($connectioni, $query);
            }

			mysqli_query($connectioni, "UNLOCK TABLES;");
		}
		
	}
	
	if ( isset($_POST['action']) && $_POST['action'] == "delete" ){
		$query = "DELETE FROM tasks WHERE task_id_pk='{$_POST['task_id_pk']}'";
		mysql_query($query);
        $task_id = $_POST['task_id_pk'];
        $query = "INSERT INTO task_action_log (tal_user_id_fk, tal_date, tal_change_type_id_fk, tal_task_id_fk, tal_old_attribute_value, tal_new_attribute_value) VALUES('{$_POST['task_creator_id_fk']}', CURRENT_DATE, 3, '{$task_id}', '{$_POST['task_name']}', '')";
        mysql_query($query);
		echo "DONE Delete";		
	}
	

	
?>

<?php include('includes/footer.php')?>

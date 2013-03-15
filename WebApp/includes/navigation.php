			<div id="navigation">
					<ul>
						<li><a href="index.php">Home Page</a></li>
						<li>
							<a href="iterations.php">Iterations</a>
							<ul>
								<?php
								
									$query = "SELECT  * FROM iterations ORDER BY iteration_start_date DESC LIMIT 5";
									$items = mysql_query($query, $connection);
									while ($item = mysql_fetch_array($items))
									{
										echo "<li><a href='iterations.php?id={$item["iteration_id_pk"]}'>{$item["iteration_start_date"]} - {$item["iteration_end_date"]}<a/></li>";
									}
								
								?>
							</ul>
						</li>
						<li><a href="settings.php">Settings</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
			</div>
			
<?php if ( strstr(strtolower($_SERVER['PHP_SELF']),'saveboard.php') != 'saveboard.php' ): ?>		
		</div>
		<div id="footer">
			<!-- <span>Copyright 2013, CSCI 511</span> -->
		</div>
	</body>
</html>	
<?php endif; ?>
<?php
	mysql_close($connection);
?>
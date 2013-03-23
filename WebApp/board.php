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
		width:110px;
		height:110px;
	}
	
	.portlet-container{
		background-color:yellow;
		border:1px solid maroon;
	}
	
	 .portlet-header { 
		margin: 0.3em; 
		padding-bottom: 4px; 
		padding-left: 0.2em; 
	 }
	 
	  .portlet-content { 
		padding: 0.4em; 
	}
  
	.taskContainer{
		width:100%;
		height:100%;
		padding:2px;
	}
	
	.taskContainer li{
		float:left;
		list-style: none;
		margin:9 3px;
	}
	
</style>

<script type="text/javascript">

	$(function() {
		
		$('.taskContainer').sortable({
			connectWith: ".taskContainer"
		});		
		
		$( ".portlet-container" ).addClass( "ui-widget ui-helper-clearfix ui-corner-all" );
		 $( ".taskContainer" ).disableSelection();
		
	});

</script>

			<div id="content" style="width:80%;height:90%">
				
				
				<div class="column">
						
						<ul class="taskContainer">
							<li class="portlet">							
								<div class="portlet-container">
									<div class="portlet-header">ss</div>
								    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
								</div>								
							</li>															
							<li class="portlet">							
								<div class="portlet-container">
									<div class="portlet-header">1 12983923 </div>
								    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
								</div>
							</li>															
							<li class="portlet">							
								<div class="portlet-container">
									<div class="portlet-header">2 dkand9jd</div>
								    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
								</div>
							</li>															
							<li class="portlet">							
								<div class="portlet-container">
									<div class="portlet-header">3 9eijasda</div>
								    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
								</div>
							</li>															
							<li class="portlet">							
								<div class="portlet-container">
									<div class="portlet-header">4 knkasda j</div>
								    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
								</div>
							</li>															
								<li class="portlet">							
									<div class="portlet-container">
										<div class="portlet-header">2 dkand9jd</div>
									    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
									</div>
								</li>															
								<li class="portlet">							
									<div class="portlet-container">
										<div class="portlet-header">3 9eijasda</div>
									    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
									</div>
								</li>															
								<li class="portlet">							
									<div class="portlet-container">
										<div class="portlet-header">4 knkasda j</div>
									    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
									</div>
								</li>
									<li class="portlet">							
										<div class="portlet-container">
											<div class="portlet-header">2 dkand9jd</div>
										    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
										</div>
									</li>															
									<li class="portlet">							
										<div class="portlet-container">
											<div class="portlet-header">3 9eijasda</div>
										    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
										</div>
									</li>															
									<li class="portlet">							
										<div class="portlet-container">
											<div class="portlet-header">4 knkasda j</div>
										    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
										</div>
									</li>
										<li class="portlet">							
											<div class="portlet-container">
												<div class="portlet-header">2 dkand9jd</div>
											    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
											</div>
										</li>															
										<li class="portlet">							
											<div class="portlet-container">
												<div class="portlet-header">3 9eijasda</div>
											    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
											</div>
										</li>															
										<li class="portlet">							
											<div class="portlet-container">
												<div class="portlet-header">4 knkasda j</div>
											    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
											</div>
										</li>
						</ul>							
					</td>
					
					
					
				</div>
				
				<div class="column">
					
						<ul class="taskContainer">
								<li class="portlet">							
								<div class="portlet-container">
										<div class="portlet-header">3 9eijasda</div>
									    <div class="protlet-content">sssssd fnkds fksdf lksf kdlsjf ksdfj kslf lkdsjks</div>
									</div>
								</li>
						</ul>
				</div>
				
				<div class="column">
					<ul class="taskContainer">
					</ul>					
				</div>
				
				
				<!-- <table cellpadding="0" cellspacing="0" border="1" style="width:100%;height:90%">
								<tr>
									<td style="width:33%; vertical-align:top;">
										<ul class="taskContainer">
											<li><div class="taskBox"></div></li>															
										</ul>							
									</td>
									<td style="width:33%; vertical-align:top;">
										s
									</td>
									<td style="width:33%; vertical-align:top;">
										ss
									</td>
								</tr>
							</table> -->
					
			</div>

<?php include('includes/footer.php')?>
<?php include("partials/doc_header.php");?>
<body class="login_home">
	   <!-- Back Navigation -->
	<nav class="navbar navbar-light bg-light sticky-top">
        <a class="navbar-brand" href="../includes/logout.php?user=doctor"><i class="fas fa-backward"></i> Logout</a>
    </nav>

	<!-- Nav Bar -->
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#009879;">
		<a class="navbar-brand font-weight-bold" href="">WELCOME TO E MEDICAL SERVICES</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		  <ul class="navbar-nav ml-auto">
          <?php
		  include('../includes/db_connect.php');
            $query = "SELECT COUNT(*) AS count FROM `appointment` WHERE doc_emailid='$loggeddoc_email' AND userstatus='1' AND doctorstatus='1'";
            $query_run= mysqli_query($connect,$query);
            			
            while($row=mysqli_fetch_assoc($query_run))
            {
			$output =$row['count'];
			if($row['count']>0)
			{
			?>
			<li>
			<span class="badge bg-warning" style="margin-top:10px;"><?php echo $output?></span></li>
	
			<?php
			}
			}
			?>
			<li class="nav-item">
			  <a class="nav-link" href="doc_appointmentlist.php">Appointment List</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="doc_preslist.php">Prescription List</a>
			</li>
			
		  </ul>
		</div>
	  </nav>

	<center>
		<p class="login_home-header1 h3">WELCOME DOCTOR <p class="h1 font-weight-bold text-warning">
	   <?php 
	   
		   echo $loggeddoc_name;
		
	    ?> </p></p>
		<h1 class="login_home-header2">E MEDICAL SERVICES WELCOME YOU</h1>
	</center>	
<?php include("partials/doc_footer.php");?>

<?php include('partials/pat_header.php');?>
<body class="login_home">
	   <!-- Back Navigation -->
	<nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="../includes/logout.php?user=patient"><i class="fas fa-backward"></i> Logout</a>
    </nav>

	<!-- Nav Bar -->
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#009879;">
		<a class="navbar-brand font-weight-bold" href="">WELCOME TO E MEDICAL SERVICES </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		  <ul class="navbar-nav ml-auto">
			<li class="nav-item">
			  <a class="nav-link" href="pat_doclist.php">Doctor List</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="pat_appointmentlist.php">Appointment List</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="pat_preslist.php">Prescription List</a>
			</li>
			<?php
            $query = "SELECT COUNT(*) AS count FROM `prescription` WHERE user_emailid='$loggeduser_email' AND status='0'";
            $query_run= mysqli_query($connect,$query);
            			
            while($row=mysqli_fetch_assoc($query_run))
            {
			$output =$row['count'];
			if($row['count']>0)
			{
			?>
			<li>
			<span class="badge bg-warning" style="margin-top:10px;"><?php echo $output?></span>
            </li>
			<?php
			}
			}
			?>
			
		  </ul>
		</div>
	  </nav>


	<div class="welcome-pat">
		<center>
			<p class="login_home-header1 h3 font-weight-bold">WELCOME <span class=" h1 text-warning font-weight-bold">
	   <?php 
	   
		   echo $loggeduser_name;
		
	    ?> </span></p>
			<h1 class="login_home-header2 font-weight-bold">E MEDICAL SERVICES WELCOME YOU</h1>
		</center>
    </div>
<?php include('partials/pat_footer.php');?>

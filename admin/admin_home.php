<?php include('partials/admin_header.php');?>
<body class="login_home">
    
	   <!-- Back Navigation -->
	<nav class="navbar navbar-light bg-light sticky-top">
        <a class="navbar-brand font-weight-bold" href="../includes/logout.php?user=admin"><i class="fas fa-backward"></i> Logout</a>
    </nav>

	<!-- Nav Bar -->
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#009879;">
		<a class="navbar-brand font-weight-bold" href="">WELCOME TO E MEDICAL SERVICES</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
		  <ul class="navbar-nav ml-auto">
			<li class="nav-item">
			  <a class="nav-link" href="admin_doclist.php">Doctor List</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="admin_patlist.php">Patient List</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="admin_appointmentlist.php">Appointment List</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="admin_departlist.php">Department List</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="admin_expiredlist.php">Expired List</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="admin_preslist.php">Prescription list</a>
			</li>
		  </ul>
		</div>
	  </nav>


	<center>
		<p class="login_home-header1 h3">WELCOME <span class="h1 font-weight-bold text-warning">ADMIN</span></p>
		<h1 class="login_home-header2">E MEDICAL SERVICES WELCOME YOU</h1>
	</center>
<?php include('partials/admin_footer.php');?>

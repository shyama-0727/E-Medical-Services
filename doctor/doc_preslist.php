<?php include('partials/doc_header.php');?>
<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `prescription` WHERE doc_emailid='$loggeddoc_email' AND CONCAT( `sno`, `doc_emailid`, `user_emailid`, `disease`, `medicine`, `meet`, `message`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `prescription` where doc_emailid='$loggeddoc_email' ";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    include("../includes/db_connect.php");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

?>

<body class="table">
     <!-- Back Navigation -->
	<nav class="navbar navbar-light bg-light sticky-top">
        <a class="navbar-brand" href="doc_home.php"><i class="fas fa-backward"></i> Back</a>
        <form class="d-flex"  action="" method="POST" autocomplete="off">
        <input class="form-control me-2" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
      </form>
    </nav>

    <h1 style="color:#009879;">PRESCRIPTION DETAILS</h1><br>

<div class="table-responsive">
   <table class="content-table table">
        <thead>
        <tr>   
        <th>SNO</th>    
        <th>DOCTOR_EMAILID</th>    
        <th>USER_EMAILID</th>    
        <th>DISEASE</th>   
        <th>MEDICINE</th>   
        <th>MEETING</th>   
        <th>CURE</th>     
        <th>PAYMENTSTATUS</th>     
        <th>ACTION</th>     
        </tr>
		</thead>

 <!-- populate table from mysql database -->
                <?php
				$count=0;
				while($row = mysqli_fetch_array($search_result)):
				$count +=1;  
				  ?>
       
        <tr>
            
            <td><?php echo $count; ?></td>
            <td><?php echo $row['doc_emailid'] ?></td>
            <td><?php echo $row['user_emailid'] ?></td>
            <td><?php echo $row['disease'] ?></td>
            <td><?php echo $row['medicine'] ?></td>
            <td><?php echo $row['meet'] ?></td>
            <td><?php echo $row['message'] ?></td>
			<td>
				<?php
			 if(($row['status']==1))  {
				 echo "Paid";
			 }
			 else {
				 echo "Pending";
			 }
			 ?>
			</td>
			<form action="partials/doctor_db.php" method="POST" role="form">
            <input type='hidden' name='sno' value='<?php echo $row['sno']?>'/>
			<td>
			<?php
			  if($row['status']==0){
               echo   "<input type='submit' class='btn btn-danger'style='outline:none;' name='doc_prescriptiondelete' onclick='return checkdelete();' value='DELETE' />";
			  }
              else{
                  echo "The Patient has paid the bill";
              }
		   ?>
		   </td>
			
        </form>
	    </tr>
         
		

<?php endwhile;?>
        </table>
        </div>
<?php include('partials/doc_footer.php');?>

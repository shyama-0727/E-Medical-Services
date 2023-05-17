<?php include('partials/pat_header.php');?>
<?php
if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `prescription` WHERE user_emailid='$loggeduser_email' AND CONCAT( `doc_emailid`, `user_emailid`, `disease`, `medicine`, `meet`, `message`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `prescription` where user_emailid='$loggeduser_email' ";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    include('../includes/db_connect.php');
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

?>
<body class="table">
     <!-- Back Navigation -->
	<nav class="navbar navbar-light bg-light sticky-top">
        <a class="navbar-brand" href="pat_home.php"><i class="fas fa-backward"></i> Back</a>
        <form class="d-flex"  action="" method="POST" autocomplete="off">
        <input class="form-control me-2" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success ml-2" type="submit" name="search">Search</button>
      </form>
    </nav>
    
    <h1 style="color:#009879;">PRESCRIPTION DETAILS</h1><br>
	
<div class="table-responsive">
   <table class="content-table table">
        <thead>
        <tr>   
        <th>FULLNAME</th>    
        <th>EMAIL_ID</th>    
        <th>DOCTOR_EMAILID</th>    
        <th>DISEASE</th>   
        <th>MEDICINE</th>   
        <th>MEETING</th>   
        <th>CURE</th>     
        <th>FEES</th>     
        <th>PAYMENT_STATUS</th>     
        <th>ACTION</th>     
        </tr>
		</thead>
	
 <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
       
        <tr>
            
            <td><?php echo $row['fullname'] ?></td>
            <td><?php echo $row['user_emailid'] ?></td>
            <td><?php echo $row['doc_emailid'] ?></td>
            <td><?php echo $row['disease'] ?></td>
            <td><?php echo $row['medicine'] ?></td>
            <td><?php echo $row['meet'] ?></td>
            <td><?php echo $row['message'] ?></td>
            <td><?php echo "Rs ".$row['cfees']."/-" ?></td>
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
			<td>
			   <form method="POST" action='partials/patient_db.php'>
                    <input type='hidden' name='fullname' value='<?php echo $row['fullname'] ?>'/>
                    <input type='hidden' name='gen' value='<?php echo $row['gender'] ?>'/>
                    <input type='hidden' name='mobile' value='<?php echo $row['mobile'] ?>'/>
                    <input type='hidden' name='appointdate' value='<?php echo $row['adate'] ?>'/>
                    <input type='hidden' name='appointtime' value='<?php echo $row['atime'] ?>'/>
                    <input type='hidden' name='u_emailid' value='<?php echo $row['user_emailid'] ?>'/>
                    <input type='hidden' name='d_emailid' value='<?php echo $row['doc_emailid'] ?>'/>
                    <input type='hidden' name='disease' value='<?php echo $row['disease'] ?>'/>
                    <input type='hidden' name='medicine' value='<?php echo $row['medicine'] ?>'/>
                    <input type='hidden' name='message' value='<?php echo $row['message'] ?>'/>
                    <input type='hidden' name='meeting' value='<?php echo $row['meet'] ?>'/>
                    <input type='hidden' name='fees' value='<?php echo $row['cfees'] ?>'/>
			      <?php
					    if(($row['status']==1))  {
                 echo "<input id='btn' class='btn btn-primary btn-sm' type='submit' style='outline:none' name='pat_downloadpdf'  value='Download Prescription' onclick='return genereatepdf();'/>";
			        }
            ?>
			 </form>
			   <form method="POST" action='partials/patient_db.php'>
			      <input type='hidden' name='SNo' value='<?php echo $row['sno'] ?>'/>
			      <?php
					    if(($row['status']==0))  {
                  echo "<input class='btn btn-primary' type='submit' style='outline:none' name='pat_pay'  value='Pay Bill' onclick='return bill();'/>";
        		  }
					  ?>
				</form>
			</td>
	    </tr>
         
		

<?php endwhile;?>
        </table>
        </div>
<script>

</script>
<?php include('partials/pat_footer.php');?>
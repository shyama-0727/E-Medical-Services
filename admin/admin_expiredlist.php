<?php include('partials/admin_header.php'); ?>
<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `pattable` INNER JOIN `appointment` ON pattable.email=appointment.user_emailid WHERE appointment.appointmentdate < CURDATE() AND CONCAT(pattable.email,pattable.phoneno,pattable.gender,appointment.doc_emailid,appointment.userstatus,appointment.doctorstatus,appointment.specialization,appointment.consultancyfees,appointment.appointmenttime,appointment.appointmentdate) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `pattable` INNER JOIN `appointment` ON pattable.email=appointment.user_emailid where appointment.appointmentdate < CURDATE() ";
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
        <a class="navbar-brand font-weight-bold" href="admin_home.php"><i class="fas fa-backward"></i> Back</a>
        <form class="d-flex"  action="" method="POST" autocomplete="off">
        <input class="form-control" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success ml-2" type="submit" name="search">Search</button>
      </form>
    </nav>

    <h1 class="font-weight-bold"style="color:#009879">EXPIRED APPOINTMENT DETAILS</h1><br>
    <div class="table-responsive">
    <table class="content-table table">
      <thead>
        <tr>  
          <th>SNO</th>    
          <th>USER_EMAILID</th>  
          <th>DOCTOR_EMAILID</th>   		
          <th>DISEASE</th>   		
          <th>EMAIL</th>   
          <th>PHONENUMBER</th>   
          <th>GENDER</th>   
          <th>SPECIALIZATION</th>   
          <th>APPOINTMENT_DATE</th>   
          <th>APPOINTMENT_TIME</th>   
          <th>CONSULTANCY_FEES</th>   
          <th>STATUS</th>      
          <th>ACTION</th>      
        </tr>
      </thead>    

  <!-- populate table from mysql database -->
      <?php 
      $count=0;
      while($row = mysqli_fetch_array($search_result)):
      $count+=1;
      ?>
    
      <tr>     
        <td><?php echo $count; ?></td>
        <td><?php echo $row['user_emailid']; ?></td>
        <td><?php echo $row['doc_emailid']; ?></td>
        <td><?php echo $row['disease']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phoneno']; ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><?php echo $row['specialization']; ?></td>
        <td><?php echo $row['appointmentdate']; ?></td>
        <td><?php echo $row['appointmenttime']; ?></td>
        <td><?php echo $row['consultancyfees']; ?></td>   
        <td>		
        <?php

                    if(($row['userstatus']==1) && ($row['doctorstatus']==1))  
                    {
                      echo "Active";
            
                    }
                    if(($row['userstatus']==1) && ($row['doctorstatus']==2))  
                    {
                      echo "Patient Appointment accepted";
            
                    }
                    if(($row['userstatus']==0) && ($row['doctorstatus']==1))  
                    {
                      echo "Cancelled by Patient";
                    }
      
                    if(($row['userstatus']==1) && ($row['doctorstatus']==0))  
                    {
                      echo "Cancelled By the Doctor";
                    }
        ?> 
        </td>
        <form action="partials/admin_db.php" method="POST" role="form">
          <td>
            <input type='hidden' name='Sno' value='<?php echo $row['sno']?>'/>
            <input type='submit' class='btn btn-danger' name='admin_appointmentdelete' style="outline:none;"onclick='return check_appointdelete()' value='DELETE' />
          </td>
        </form>
    </tr>
    
    <?php endwhile;?>
  </table>
  </div>
<?php include('partials/admin_footer.php'); ?>
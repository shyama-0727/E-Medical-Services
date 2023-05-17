<?php include('partials/admin_header.php');?>
<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `pattable` WHERE CONCAT( `fullname`, `email`, `phoneno`,`gender`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `pattable` ";
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
        <input class="form-control me-2" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success ml-2" type="submit" name="search">Search</button>
      </form>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
        <h1 class="font-weight-bold" style="color:#009879">PATIENTS LIST</h1>
        <a class="btn btn-success mr-4"  data-toggle="modal" data-target="#Addpatient" data-whatever="@mdo" style="background-color:#009879" href="#">Add Patient</a>
    </div>

    <!-- Add patient modal -->
<div class="modal fade" id="Addpatient" tabindex="-1" role="dialog" aria-labelledby="AddpatientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="../patient/partials/patient_db.php">
                <div class="modal-body">
                    <input type="hidden" name="admin_patadd" value="admin_patadd">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Patient FullName :</label>
                        <input type="text" class="form-control" placeholder="Enter the Full Name" name="fullname" id="add_patfullname">
                    </div>
                    <div class="form-group">
                         <label for="message-text" class="col-form-label">Patient Emailid:</label>
                        <input type="email" class="form-control" placeholder="Enter the Emailid" name="email" id="add_patemail">
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Patient Phoneno:</label>
                        <input type="number" class="form-control" placeholder="Enter the Phone Number" name="phoneno" id="add_patphoneno">
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Patient Password:</label>
                        <input type="password" class="form-control" placeholder="Enter the Password" name="password" id="add_patpass">
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Patient ConfirmPassword:</label>
                        <input type="password" class="form-control" placeholder="Enter the Confirm password" name="cpassword" id="add_patconpass">
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Patient Gender:</label>
                         <select name="gender" class="form-control" required>
                            <option value="" disabled selected>--Select Gender--</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"  style="background-color:#009879" name="pat_register">Add Patient</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <div class="table-responsive">
        <table class="content-table table">
            <thead>
            <tr>  
                <th>FULL NAME</th>      
                <th>EMAIL</th> 		
                <th>PHONE NUMBER</th>   
                <th>GENDER</th>      
                <th>ACTION</th>      
            </tr>
            </thead>
            
        <!-- populate table from mysql database -->
                    <?php while($row = mysqli_fetch_array($search_result)):?>
            
            <tr>
                <td><?php echo $row['fullname'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['phoneno'] ?></td>
                <td><?php echo $row['gender'] ?></td>
                <form action="partials/admin_db.php" method="POST" role="form">
                    <td>
                        <input type='hidden' name='email' value='<?php echo $row['email']?>' />
                        <input type='submit' class='btn btn-danger' name='admin_patientdelete' onclick='return check_patdelete()' value='DELETE' />
                    </td>
                </form>
            </tr>
            
            
            <?php endwhile;?>
        </table>
    </div>
<?php include('partials/admin_footer.php');?>
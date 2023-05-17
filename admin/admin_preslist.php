<?php include('partials/admin_header.php');?>
<?php
if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `prescription` WHERE CONCAT( `doc_emailid`,`user_emailid`, `disease`, `medicine`, `meet`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `prescription`";
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
        <a class="navbar-brand" href="admin_home.php"><i class="fas fa-backward"></i> Back</a>
        <form class="d-flex"  action="" method="POST" autocomplete="off">
        <input class="form-control" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success ml-2" type="submit" name="search">Search</button>
      </form>
    </nav>
    <h1 style="color:#009879;">Prescription Details</h1><br>
	

    <div class="table-responsive">
   <table class="content-table table">
        <thead>
        <tr>   
        <th>FULLNAME</th>    
        <th>USER_EMAILID</th>    
        <th>DOCTOR_EMAILID</th>    
        <th>DISEASE</th>   
        <th>MEDICINE</th>   
        <th>MEETING</th>   
        <th>CURE</th>     
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
	    </tr>
<?php endwhile;?>
</table>
</div>
<?php include('partials/admin_footer.php');?>
<?php include('partials/pat_header.php');?>

<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `doctable` WHERE CONCAT(`doc_emailid`, `docname`, `docgender`,`docnum`,`specilaization`, `consultancyfees`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `doctable` ";
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
        <input class="form-control mr-2" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
      </form>
    </nav>

	<h1 style="color:#009879">YOU CAN SEE THE DOCTOR'S ID HERE FOR BOOKING APPOINTMENTS</h1><br>



    <div class="table-responsive">
        <table class="content-table table">
            <thead>
            <tr>  
            <th>SNO</th>     
            <th>DOCTOR_EMAILID</th>     
            <th>DOCTORNAME</th>
            <th>GENDER</th>
            <th>PHONENUMBER</th>
            <th>SPECIALIZATION</th> 		  
            <th>CONSULTANCYFEES</th>      
            </tr>
            </thead>
            
            <!-- populate table from mysql database -->
                <?php 
                $count=0;   
                while($row = mysqli_fetch_array($search_result)):
                $count++;
                ?>
        
            <tr>
            <td><?php echo $count ?></td>
            <td><?php echo $row['doc_emailid'] ?></td>
            <td><?php echo $row['docname'] ?></td>
            <td><?php echo $row['docgender'] ?></td>
            <td><?php echo $row['docnum'] ?></td>
            <td><?php echo $row['specilaization'] ?></td>
            <td><?php echo "Rs ".$row['consultancyfees']."/-" ?></td>
            </tr>
            
            <?php endwhile;?>
        </table>
    </div>


<?php include('partials/pat_footer.php');?>
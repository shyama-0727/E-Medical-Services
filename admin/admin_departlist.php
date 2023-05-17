<?php include('partials/admin_header.php');?>

<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `department` WHERE CONCAT(`depart_name`,`depart_img`, `depart_para1`,`depart_para2`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `department` ";
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
        <input class="form-control mr-2" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
      </form>
    </nav>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
        <h1 class="font-weight-bold" style="color:#009879">DEPARTMENT LIST</h1>
        <a class="btn btn-success mr-4" data-toggle="modal" data-target="#Adddepartment" data-whatever="@mdo" style="background-color:#009879" href="#">Add Department</a>
    </div>

<!-- Add department modal -->
<div class="modal fade" id="Adddepartment" tabindex="-1" role="dialog" aria-labelledby="AdddepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="partials/admin_db.php" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Department Name :</label>
                        <input type="text" class="form-control" placeholder="Enter the Department Name" name="add_departname" id="add_departname">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Department Logo Image :</label>
                        <input type="file" class="form-control" name="Department_image" id="Department_image">
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea">Department Content 1 :</label>
                        <textarea class="form-control" placeholder="Leave the content here" name="depart_para1" id="depart_para1"></textarea>  
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea">Department Content 2 :</label>
                        <textarea class="form-control" placeholder="Leave the content here" name="depart_para2" id="depart_para2"></textarea>
                    </div>
                    <div class="form-group">
                         <label for="message-text" class="col-form-label">Department Fees :</label>
                        <input type="text" class="form-control" placeholder="Enter the Amount" name="depart_amt" id="depart_amt">
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Select Department Morning Time :</label>
                        <select name="depart_mrgtime" id="depart_mrgtime" class="form-control" >
                        <option value="" disabled selected>--Select Time--</option>
                            <option value="08:00:00">08:00 AM</option>
                            <option value="09:00:00">09:00 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="11:00:00">11:00 AM</option> 
                        </select>
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Department Evening Time :</label>
                         <select name="depart_evetime" id="depart_evetime" class="form-control" >
                         <option value="" disabled selected>--Select Time--</option>
                            <option value="13:00:00">01:00 PM</option>
                            <option value="14:00:00">02:00 PM</option>
                            <option value="15:00:00">03:00 PM</option>
                            <option value="16:00:00">04:00 PM</option> 
                        </select>                  
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"  style="background-color:#009879" name="admin_adddepartment">Add Department</button>
                </div>
            </form>
            </div>
        </div>
        </div>

    <div class="table-responsive">
        <table class="content-table table">
            <thead>
            <tr>  
            <th>DEPARTMENT_NAME</th>     
            <th>DEPARTMENT_IMAGE</th> 
            <th>DEPARTMENT_CONTENT 1</th>
            <th>DEPARTMENT_CONTENT2</th>		
            <th>DEPARTMENT_FEES</th>      
            <th>AVAILABLE_TIME</th>            
            <th>ACTION</th>      
            </tr>
            </thead>

        <!-- populate table from mysql database -->
                        <?php while($row = mysqli_fetch_array($search_result)):?>
      
        <tr>
        <td><?php echo $row['depart_name'] ?></td>
        <td><?php echo '<img src="../assets/images&gif/Departments/'.$row['depart_img'].'" width="70" height="60" style="border-radius:50%">' ?></td>
        <td><?php echo substr($row['depart_para1'],0,100)." ..."?></td>
        <td><?php echo substr($row['depart_para2'],0,100)." ..."?></td>
        <td><?php echo 'Rs '.$row['depart_amt'].'/-'?></td>
        <td><?php echo $row['depart_mrgtime']." & ".$row['depart_evetime']?></td>
        <td class="d-flex">

		    <form>
		        <input type='hidden' name='id' value='<?php echo $row['id'] ?>'/>
                <a href="admin_departlist.php?id=<?php echo $row['id']?>"  name='admin_departedit' class="px-3 btn btn-info btn-sm">Edit</a>
            </form>
            <?php		
				        echo "<form method='POST' action='partials/admin_db.php'><input type='hidden' name='id' value='".$row['id']."'/><input  class='btn btn-danger btn-sm ml-2' type='submit' style='outline:none;' name='admin_departdelete' onclick='check_departdelete()'  value='DELETE' /></form>";				
				?>
			
        </td>
    </tr>
  

<?php endwhile;?>
    </table>
</div>

<?php
if (isset($_GET['id'])) {
    include('../includes/db_connect.php');
    $id = $_GET["id"];
    $department = mysqli_query($connect, "SELECT * FROM department WHERE id = '$id'");
    $depart = mysqli_fetch_assoc($department);
    echo '
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
            <script>
                $(document).ready(function(){
                    $("#Editdepartment").modal(); 
                });
            </script>
        ';
    echo '
<!-- Edit department modal -->
<div class="modal fade" id="Editdepartment" tabindex="-1" role="dialog" aria-labelledby="EditdepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="partials/admin_db.php" enctype="multipart/form-data">
                <div class="modal-body">
                        <input type="hidden" name="edit_id" value="'.$id.'">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Department Name :</label>
                        <input type="text" class="form-control" placeholder="Enter the Department Name" name="edit_departname" id="edit_departname" value="'.$depart['depart_name'].'">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Department Logo Image :</label>
                        <input type="file" class="form-control" name="Edit_Department_image" id="Edit_Department_image" value="'.$depart['depart_img'].'">
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea">Department Content 1 :</label>
                        <textarea class="form-control" name="edit_depart_para1" id="edit_depart_para1">'.$depart['depart_para1'].'</textarea>  
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea">Department Content 2 :</label>
                        <textarea class="form-control"  name="edit_depart_para2" id="edit_depart_para2">'.$depart['depart_para2'].'</textarea>
                    </div>
                    <div class="form-group">
                         <label for="message-text" class="col-form-label">Department Fees :</label>
                        <input type="text" class="form-control" placeholder="Enter the Amount" name="edit_depart_amt" id="edit_depart_amt" value="'.$depart['depart_amt'].'">
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Select Department Morning Time :</label>
                        <select name="edit_depart_mrgtime" id="edit_depart_mrgtime" class="form-control" >
                        <option value="" disabled selected>--Select Time--</option>
                            <option value="08:00:00">08:00 AM</option>
                            <option value="09:00:00">09:00 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="11:00:00">11:00 AM</option> 
                        </select>
                   </div>
                   <div class="form-group">
                         <label for="message-text" class="col-form-label">Department Evening Time :</label>
                         <select name="edit_depart_evetime" id="edit_depart_evetime" class="form-control" >
                         <option value="" disabled selected>--Select Time--</option>
                            <option value="13:00:00">01:00 PM</option>
                            <option value="14:00:00">02:00 PM</option>
                            <option value="15:00:00">03:00 PM</option>
                            <option value="16:00:00">04:00 PM</option> 
                        </select>                  
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"  style="background-color:#009879" name="admin_editdepartment">Edit Department</button>
                </div>
            </form>
            </div>
        </div>
        </div>';
}
?>


<?php include('partials/admin_footer.php');?>

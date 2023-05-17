<?php include('partials/admin_header.php');
?>

<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `doctable` WHERE CONCAT(`doc_emailid`,`docname`, `docgender`,`docnum`,`specilaization`,`consultancyfees`) LIKE '%".$valueToSearch."%'";
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
        <a class="navbar-brand font-weight-bold" href="admin_home.php"><i class="fas fa-backward"></i> Back</a>
        <form class="d-flex"  action="" method="POST" autocomplete="off">
        <input class="form-control mr-2" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
      </form>
    </nav>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="font-weight-bold" style="color:#009879">DOCTORS LIST</h1>
        <a class="btn btn-success mr-4" style="background-color:#009879" data-toggle="modal" data-target="#Adddoctor" data-whatever="@mdo" style="background-color:#009879" href="#">Add Doctor</a>
    </div>


    
<!-- Add doctor modal -->
<div class="modal fade" id="Adddoctor" tabindex="-1" role="dialog" aria-labelledby="AdddepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Add Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="partials/admin_db.php">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Doctor Email :</label>
                        <input type="text" class="form-control" placeholder="Enter the Doctor Email id" name="doctor_emailid" id="doctor_emailid">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Doctor FullName :</label>
                        <input type="text" class="form-control" placeholder="Enter the Doctor FullName" name="doctorname" id="doctorname">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Doctor Phoneno :</label>
                        <input type="text" maxlength="10" class="form-control" placeholder="Enter the Doctor Contact Number" name="docnum" id="docnum">
                    </div>
                    <label for="message-text" class="col-form-label">Doctor Gender:</label>
                    <select name="docgender" class="form-control" id="docgender">
                        <option value="" disabled selected>--Select Gender--</option>
                        <option value=" Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select><br>
                    <label for="message-text" class="col-form-label">Doctor Department :</label>
                    
		            <select name="spec" class="form-control" id="spec" onchange="select_depart(this.value);">
                        <option value="" disabled selected>--Select Specialization--</option>
                        <?php
                            include('../includes/db_connect.php');
                            $depart = "SELECT depart_name FROM `department`";

                            $depart_run= mysqli_query($connect,$depart);
                                
                            while($d_name=mysqli_fetch_array($depart_run))
                            {
                                echo '<option value="'.$d_name['depart_name'].'">'.$d_name['depart_name'].'</option>';
                            }
                        ?>
                    </select><br>

                    <script  type="text/javascript" charset="utf-8" async defer>
                        function select_depart(str) {
                            //console.log(str);
                            if (window.XMLHttpRequest) {
                                xmlhttp = new XMLHttpRequest();
                            }
                            else
                            {
                                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            xmlhttp.onreadystatechange = function(){
                            if (this.readyState==4 && this.status==200) {
                                document.getElementById('fees').innerHTML = this.responseText;
                            }
                            }
                            xmlhttp.open("GET","partials/admin_db.php?select_depart="+str, true);
                            xmlhttp.send();

                        }
                </script>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Doctor Password :</label>
                        <input type="password" class="form-control" placeholder="Enter the Doctor Password" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Doctor Confirm Password :</label>
                        <input type="password" class="form-control" placeholder="Enter the Doctor Confirm Number" name="cpassword" id="cpassword">
                    </div>
                    <div class="form-group" id="fees">
                        <label for="message-text" class="col-form-label">Doctor Consultacy Fees :</label>
                        <input type="text" class="form-control" placeholder="Enter the Doctor Fees" name="fees" id="fees" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"  style="background-color:#009879" name="admin_adddoctor">Add Doctor</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <div class="table-responsive">
        <table class="content-table table">
            <thead>
            <tr>  
            <th>SNO</th>     
            <th>DOCTOR_EMAILID</th>     
            <th>DOCTOR_NAME</th> 
            <th>GENDER</th>
            <th>PHONENUMBER</th>
            <th>SPECIALIZATION</th> 		
            <th>CONSULTANCY_FEES</th>      
            <th>ACTION</th>      
            </tr>
            </thead>

        <!-- populate table from mysql database -->
                        <?php $count=0;while($row = mysqli_fetch_array($search_result)): 
                            $count++;?>
      
        <tr>
        <td><?php echo $count;?></td>
        <td><?php echo $row['doc_emailid'] ?></td>
        <td><?php echo $row['docname'] ?></td>
        <td><?php echo $row['docgender']?></td>
        <td><?php echo $row['docnum'] ?></td>
        <td><?php echo $row['specilaization'] ?></td>
       <td><?php echo 'Rs '.$row['consultancyfees'].'/-' ?></td>
        <form action="partials/admin_db.php" method="POST" role="form">
        <td>
            <input type='hidden' name='doc_emailid' value='<?php echo $row['doc_emailid']?>'/>
            <input type='submit' class='btn btn-danger' name='admin_docdelete' onclick='return check_docdelete()' value='DELETE' />
        </td>
        </form>
    </tr>
  

<?php endwhile;?>
    </table>
</div>
    

<?php include('partials/admin_footer.php');?>

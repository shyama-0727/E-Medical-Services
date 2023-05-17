<?php 

    $joinUrl = '';
    include('partials/doc_header.php');
    include('../config.php');
    include('../api.php');
    include('../includes/db_connect.php');

    $title = '';
    if(isset($_POST['startMeeting'])){

        

        if(isset($_POST['appointment_id']) && !empty($_POST['appointment_id'])){
            $appId = $_POST['appointment_id'];
            $query = "SELECT * FROM appointment WHERE sno=" . $_POST['appointment_id'];
            $meeting = filterTable($query);
            $meetingData = mysqli_fetch_array($meeting);
            if(!empty($meetingData['meeting_url'])){
                $joinUrl = $meetingData['meeting_url'];
				$startUrl = $meetingData['start_url'];
                header("Location: $startUrl");
            }
        }
            $title = $_POST['title'];
            $pat_email = $_POST['pat_id'];
            $arr['topic'] = $title;
            $arr['start_date'] = date('Y-m-d h:i:s', strtotime("+2 minutes"));
            $arr['duration'] = 30;
            $arr['password'] = '';
            $arr['type'] = '2';
            $result = createMeeting($arr);
			$startUrl = "";
            if(isset($result->id)){
                $joinUrl = $result->join_url;
				if(isset($result->start_url)){
                    $startUrl = $result->start_url;
                }
            }else{
                echo '<pre>';
                print_r($result);
            }
            // echo "UPDATE appointment SET meeting_url = '{$joinUrl}' WHERE user_emailid = '{$pat_email}'"; die;
           $resultMeet = mysqli_query($connect, "UPDATE appointment SET meeting_url = '{$joinUrl}', start_url = '{$startUrl}' WHERE user_emailid = '{$pat_email}'") or die("Query Failed");

            header("Location: $startUrl");
        
    }

    

    
?>
<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM `pattable` INNER JOIN `appointment` ON pattable.email=appointment.user_emailid WHERE (doc_emailid='$loggeddoc_email' OR JSON_CONTAINS(expert_list,'". "[\"" . $loggeddoc_email . "\"]'" . ")  AND   CONCAT(pattable.fullname,pattable.email,pattable.phoneno,pattable.gender,appointment.doc_emailid,appointment.specialization,appointment.consultancyfees,appointment.appointmenttime,appointment.appointmentdate) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
}else {
    $query = "SELECT  * FROM `pattable` INNER JOIN `appointment` ON pattable.email=appointment.user_emailid where doc_emailid='$loggeddoc_email' OR JSON_CONTAINS(expert_list,'". "[\"" . $loggeddoc_email . "\"]'" . ")";

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
        <a class="navbar-brand" href="doc_home.php"><i class="fas fa-backward"></i> Back</a>
        <form class="d-flex"  action="" method="POST" autocomplete="off">
        <input class="form-control mr-2" type="search" name="valueToSearch" placeholder="Value To Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
      </form>
    </nav>
    <h1 style="color:#009879">APPOINTMENT DETAILS</h1><br>
    
    <div class="table-responsive">
	<table class="content-table table">
        <thead>
        <tr>
        <th>SNO</th>	
        <th>PANEL_DETAIL</th>
        <th>PATIENT_FULLNAME</th>   
        <th>PATIENT_EMAILID</th>     
        <th>CONTACT</th>
        <th>GENDER</th>   
        <th>DISEASE</th>   
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
        $count = $count+1;
   ?>
      
        <tr class="activerow"> 
            <td><?php echo $count?></td>
            <td><?php 
            if(!empty($row['expert_list'])){
                echo implode(",<br>", json_decode($row['expert_list']));
            }
            ?></td>
            <td><?php echo $row['fullname'] ?></td>
            <td><?php echo $row['user_emailid'] ?></td>
            <td><?php echo $row['phoneno'] ?></td>
            <td><?php echo $row['gender'] ?></td>
            <td><?php echo $row['disease'] ?></td>
            <td><?php echo $row['specialization'] ?></td>
            <td><?php echo $row['appointmentdate'] ?></td>
            <td><?php echo $row['appointmenttime'] ?></td>
            <td><?php echo "Rs ".$row['consultancyfees']."/-" ?></td>    
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
                    echo "Cancelled By the Yourself";
                }
                      ?> 

                <br><br>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_<?php echo $row['sno']; ?>"><span class="text-white">Start Meet</span></button>
        </td>
        <td>
		    <form method="POST" action='partials/doctor_db.php' class="d-flex">
		        <input type='hidden' name='SNo' value='<?php echo $row['sno'] ?>'/>
            <?php
		           if(($row['userstatus']==1) && ($row['doctorstatus']==1))  
                    {
                        if($row['doc_emailid'] == $loggeddoc_email){
                            echo "<input class='btn btn-success btn-sm' type='submit' style='outline:none' name='user_appointment_accept'  value='Accept'/>";
				            echo "<input  class='btn btn-danger btn-sm ml-2' type='submit' style='outline:none;' name='user_appointment_reject'  value='Reject' />";
                        }
					}
					
				?>
			</form>
	
<div id="myModal_<?php echo $row['sno']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Set Meeting</h4>
      </div>
      <div class="modal-body">
        <form method="POST">
            <input type="text" name="title" placeholder="Add meeting title" class="form-control">
            <input type="hidden" name="pat_id" value="<?php echo $row['email']; ?>" class="form-control">
            <input type="hidden" name="appointment_id" value="<?php echo $row['sno']; ?>" class="form-control">
            <br>
                <?php 
                    if($row['meeting_preference'] == null || $row['meeting_preference'] == "ZOOM"){ ?> 
                        <button type="submit" name="startMeeting" class="btn btn-warning">Start Zoom Meeting</button>
                <?php }
                    if($row['meeting_preference'] == null || $row['meeting_preference'] == "WHATSAPP"){ 
                ?> 
                
                    <a href="https://wa.me/91<?php echo $row['phoneno']; ?>"  name="startChat" class="btn btn-warning" data-mobile="<?php echo $row['phoneno']; ?>">Start WhatsApp</a>
                <?php } ?>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


	    <form method="GET" action=''>
		    <input type='hidden' name='name' value='<?php echo $row['fullname'] ?>'/>
		    <input type='hidden' name='user_mail' value='<?php echo $row['user_emailid'] ?>'/>
		    <input type='hidden' name='doc_mail' value='<?php echo $row['doc_emailid'] ?>'/>
		    <input type='hidden' name='no' value='<?php echo $row['phoneno'] ?>'/>
		    <input type='hidden' name='gen' value='<?php echo $row['gender'] ?>'/>
		    <input type='hidden' name='di' value='<?php echo $row['disease'] ?>'/>
		    <input type='hidden' name='appointmentdate' value='<?php echo $row['appointmentdate'] ?>'/>
		    <input type='hidden' name='appointmenttime' value='<?php echo $row['appointmenttime'] ?>'/>
		    <input type='hidden' name='cfees' value='<?php echo $row['consultancyfees'] ?>'/>
		<?php
		    if(($row['userstatus']==1) && ($row['doctorstatus']==2))  
        {
            if($row['doc_emailid'] == $loggeddoc_email){
                echo "<input class='btn btn-primary btn-sm' type='submit' style='outline:none' name='presc'  value='Prescribe'/>";
            }
            
        }
		?>
		</form>
			</td>
		</tr>
		
        
   <?php endwhile;?>
    </table>
    </div>

    
<?php
if (isset($_GET['presc'])) {
    include('../includes/db_connect.php');
    $user_mail = $_GET['user_mail'] ;
    $doc_mail = $_GET['doc_mail'] ;
    $mobile = $_GET['no'] ;
    $appointmentdate = $_GET['appointmentdate'] ;
    $appointmenttime = $_GET['appointmenttime'] ;
    $fullname = $_GET['name'] ;
    $dis =  $_GET['di'];
    $gen =  $_GET['gen'];
    $fees=$_GET['cfees'];
    echo '
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
            <script>
                $(document).ready(function(){
                    $("#sendprescription").modal(); 
                });
            </script>
        ';
    // <!-- edit product modal -->
    echo '
<!-- Send Prescription modal -->
<div class="modal fade" id="sendprescription" tabindex="-1" role="dialog" aria-labelledby="EditdepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Prescription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="partials/doctor_db.php" enctype="multipart/form-data">
              <input type="hidden" name="fname" value="'.$fullname.'"/>
              <input type="hidden" name="mobileno" value="'.$mobile.'"/>
              <input type="hidden" name="adate" value="'.$appointmentdate.'"/>
              <input type="hidden" name="atime" value="'.$appointmenttime.'"/>
              <input type="hidden" name="cfees" value="'.$fees.'"/>
                <div class="modal-body">
                       
                <div class="form-group">
                        <label for="message-text" class="col-form-label">Doctor Mailid:</label>
                        <input type="text" class="form-control" name="doc_mail" id="doc_mail" value="'.$doc_mail.'" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Patient Mailid :</label>
                        <input type="text" class="form-control" name="user_mail" id="user_mail" value="'.$user_mail.'" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Disease Name and No.of.Days in sick :</label>
                        <input type="text" class="form-control" name="dis" id="dis" value="'.$dis.'" readonly>
                    </div>
                   <div class="form-group">
                        <label for="message-text" class="col-form-label">Patient Gender :</label>
                        <input type="text" class="form-control" name="gen" id="gen" value="'.$gen.'" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Medicine :</label>
                        <input type="text" class="form-control" placeholder="Enter Medicine name"name="medicine" id="medicine" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Patient Need To Meet Your or Not :</label>
                        <input type="text" class="form-control" placeholder="Enter Yes (or) No"name="meet" id="meet" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Medicine :</label>
                        <input type="text" class="form-control" name="fees" id="fees" value="'.$fees.'" readonly>
                    </div>
                    <div class="form-group">
                        <label for="floatingTextarea">Enter the cure Here:</label>
                        <textarea class="form-control" name="message" id="message" placeholder="Enter Your Message Here"></textarea>  
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"  style="background-color:#009879" name="doc_prescriptionsend">Send Prescription</button>
                </div>
            </form>
            </div>
        </div>
        </div>';
}
?>

<?php include('partials/doc_footer.php');?>

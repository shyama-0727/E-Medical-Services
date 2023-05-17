<?php
include('../../includes/db_connect.php');


if(isset($_GET['select_dept'])){
    $selectedDept = $_GET["select_dept"];

    $val_M = mysqli_real_escape_string($connect, $selectedDept);

    $sql = "SELECT doc_emailid FROM doctable WHERE specilaization='$val_M'";
    $result= mysqli_query($connect, $sql);

   
    $dr_list = "<option style='width:280px;' disabled selected>--Select Doctor--</option>";

    if (mysqli_num_rows($result)>0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $dr_list .= "<option style='width:280px;' value=".$rows["doc_emailid"] ." >".$rows["doc_emailid"]."</option>";
        }
    } else {
        $dr_list = "<option style='width:280px;' disabled selected>--No Doctor Found--</option>";        
    }

    $allDrs = "SELECT doc_emailid FROM doctable";

    $allResult= mysqli_query($connect, $allDrs);

    $all_dr_list = "";

    if (mysqli_num_rows($allResult)>0) {
        while ($rows = mysqli_fetch_assoc($allResult)) {
            $all_dr_list .= "<option style='width:280px;' value=".$rows["doc_emailid"] ." >".$rows["doc_emailid"]."</option>";
        }
    } else {
        $all_dr_list = "<option style='width:280px;' disabled selected>--No Doctor Found--</option>";        
    }
    echo json_encode(array('data' =>  ['dr_list'  =>  $dr_list, 'all_dr_list'   =>  $all_dr_list]));
    exit;
}

if(isset($_GET['drs'])){
    
    $selectedDrs = $_GET['drs'];

    $selectedDrs = json_decode($selectedDrs, true);
    $selectedDrsStr = "'" . implode ( "', '", $selectedDrs['drs'] ) . "'";

    $getDept = [];
    $sql = "SELECT * FROM `doctable` JOIN `department` ON `doctable`.`specilaization` = `department`.`depart_name` WHERE `doctable`.`doc_emailid` IN (". $selectedDrsStr .")";

    $result = mysqli_query($connect, $sql);

    $totalFees = 0;

    $morningTime = [];
    $eveningTime = [];

    if(mysqli_num_rows($result) > 0){
        while ($rows = mysqli_fetch_assoc($result)) {
            $totalFees = $rows['consultancyfees'] + $totalFees;
            array_push($morningTime, $rows['depart_mrgtime']);
            array_push($eveningTime, $rows['depart_evetime']);
        }
    }

    $morningTime = array_unique($morningTime);
    $eveningTime = array_unique($eveningTime);

    $morningOptions = "";
    if(count($morningTime) > 0){
        foreach($morningTime as $time){
            $morningOptions .= '<option value="'.$time.'">'.$time.'</option>';
        }
    }else{
        $morningOptions = '<option value="">Time Slot Not Available</option>';
    }

    $eveningOptions = "";
    if(count($eveningTime) > 0){
        foreach($eveningTime as $time){
            $eveningOptions .= '<option value="'.$time.'">'.$time.'</option>';
        }
    }else{
        $eveningOptions = '<option value="">Time Slot not Available</option>';
    }

    $optionGroup = '<option value="" disabled selected>--Select Time--</option>
                    <optgroup label="Morning Time">' . $morningOptions . '</optgroup>
                    <optgroup label="Evening Time">'. $eveningOptions .'</optgroup>';

    
    echo json_encode(array('data' =>  ['total_fees'  =>  $totalFees, 'time_slot' => $optionGroup]));
    exit;
}

if(isset($_POST['panel_booking']))
{
    $user_mailid    =   $_POST['u_mailid'];
    $spec = $_POST['spec'];
    $doc_emailid = $_POST['panel_doc_emailid'];
    $dis = $_POST['dis'];
    $fees = $_POST['panel_fees'];
    $date = $_POST['date'];
    $time = $_POST['panel_time'];
    $meeting_pref = $_POST['panel_meeting_pref'];
    $expertList = json_encode($_POST['panel_co_doc_emailid']);
    
    $reg = "insert into appointment(user_emailid,doc_emailid,specialization,disease,consultancyfees,appointmentdate,appointmenttime,userstatus,doctorstatus, expert_list, meeting_preference) values ('$user_mailid','$doc_emailid','$spec','$dis','$fees','$date','$time','1','1', '$expertList', '$meeting_pref')";

    mysqli_query($connect, $reg);

	echo '<script>alert("Your Appointment successfully Booked wait for the doctor response")</script>';
	?>
    	<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../pat_appointmentlist.php">
	<?php
}
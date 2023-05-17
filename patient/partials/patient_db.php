<?php
// echo '<pre>';
// print_r($_POST);exit;

include('../../includes/db_connect.php');

//==============================================================PATIENT REGISTRATION=====================================================

if (isset($_POST['pat_register'])){
    $fullname= $_POST['fullname'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $password = $_POST['password'];
    $cpassword=$_POST['cpassword'];
    $gender = $_POST['gender'];
    if($password != $cpassword){
    echo "<script>alert('password is mismatching.... please re-enter your password ');</script>";
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../../pat_signup.html">
        <?php
    }
    else{
    $s = "select * from pattable where email='$email'";

    $result = mysqli_query($connect, $s);

    $num = mysqli_num_rows($result);

    if($num==1)
    {
    
        echo '<script>alert("Email id already Exists")</script>';
            ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../../pat_signup.html">
        <?php
    }
    else
    {
        $reg="insert into pattable(fullname,email,phoneno, password,gender) values ('$fullname','$email','$phoneno','$password','$gender')";
        mysqli_query($connect,$reg);
        echo '<script>alert("registration successfull")</script>';
        if (isset($_POST['admin_patadd'])){
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../../admin/admin_patlist.php">
            <?php
        }
        else{
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../../pat_doc_signin.html">
            <?php
        }
    }
    }
}


//==============================================================PATIENT LOGIN====================================================

if (isset($_POST['pat_login'])){

    session_start(); 

    $pat_email = $_POST['pat_email'];
    $pat_pass = $_POST['pat_password'];

    $s = "select * from pattable where email='$pat_email' && password='$pat_pass'";

    $result = mysqli_query($connect, $s);

    $num = mysqli_num_rows($result);

    if($num==1)
    {
        $_SESSION['email']=$pat_email;
        header('location:../pat_home.php');
    }
    else
    {
        header('location:../../loginfail.html');
    }
}


//==============================================================PATIENT PRESCRIPTION PDF DOWNLOAD=====================================================

if (isset($_POST['pat_downloadpdf'])){
 

    $fullname=$_POST['fullname'];
    $u_emailid=$_POST['u_emailid'];
    $mobile=$_POST['mobile'];
    $apdate=$_POST['appointdate'];
    $aptime=$_POST['appointtime'];
    $gender=$_POST['gen'];
    $doc_emailid = $_POST['d_emailid'] ;
    $dis =  $_POST['disease'];
    $medicine =  $_POST['medicine'];
    $meeting=$_POST['meeting'];
    $message=$_POST['message'];



$fees=$_POST['fees'];
require("../../assets/fpdf/fpdf.php");
// $db=new PDO('mysql:host=localhost;dbnme=id16205479_hms','root','');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
		$pdf->SetFont('Arial','B',30);
		$pdf->Cell(200,5,"E MEDICAL SERVICES",0,0,'C');
		$pdf->Ln(15);
		
		$pdf->SetFont('Times','',20);
		$pdf->Cell(180,5,"Doctor Prescription",0,0,'C');
        $pdf->Ln(30);
	    
		$pdf->SetFont('Arial','',15);
		$pdf->Cell(90,5,"PATIENT NAME",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$fullname",0,0);
		$pdf->Ln(12);
		
		$pdf->SetFont('Arial','',15);
		$pdf->Cell(90,5,"PATIENT EMAILID",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$u_emailid",0,0);
		$pdf->Ln(12);
		
		$pdf->SetFont('Arial','',15);
		$pdf->Cell(90,5,"PATIENT MOBILENO",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$mobile",0,0);
		$pdf->Ln(12);
		
		$pdf->SetFont('Arial','',15);
		$pdf->Cell(90,5,"PATIENT GENDER",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$gender",0,0);
		$pdf->Ln(12);
		
		
		$pdf->Cell(90,5,"APPOINTMENT DATE",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$apdate",0,0);
		$pdf->Ln(12);
		
		$pdf->Cell(90,5,"APPOINTMENT TIME",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$aptime",0,0);
		$pdf->Ln(12);
		
		$pdf->Cell(90,5,"DISEASE",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$dis",0,0);
		$pdf->Ln(12);
		
		$pdf->Cell(90,5,"DOCTOR ID",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$doc_emailid",0,0);
		$pdf->Ln(12);
		
		$pdf->Cell(90,5,"MEDICINE",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"$medicine",0,0);
		$pdf->Ln(12);
		
		$pdf->Cell(90,5,"CURE",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->MultiCell(50,7,"$message",0,0);
		$pdf->Ln(12);
		
	    $pdf->Cell(90,0,"MEET",0,0,'L');
		$pdf->Cell(20,0,":",0,0);
		$pdf->Cell(50,0,"$meeting",0,0);
		$pdf->Ln(12);

		$pdf->Cell(90,5,"FEES",0,0,'L');
		$pdf->Cell(20,5,":",0,0);
		$pdf->Cell(50,5,"RS ".$fees."/-",0,0);
		$pdf->Ln(12);
		
	
		
       
$pdf->output();
}


//==============================================================PATIENT PAYMENT=====================================================

if (isset($_POST['pat_pay'])){
    $Sno = (isset($_POST['SNo']) ? $_POST['SNo'] : 'error');
    if(isset($_POST['pat_pay']))
    {
           $query="UPDATE prescription SET status =true WHERE sno='$Sno'";
           echo "<script>window.alert('Payment Successfull')</script>";
           ?>
           <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../pat_preslist.php">
           <?php
    
       }
     else
       { 
           $query="UPDATE prescription SET status =false WHERE sno='$Sno'";
            echo "<script>window.alert('Payment Failed')</script>";
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../pat_preslist.php">
            <?php
       }
      
    
    mysqli_query($connect,$query);
}


//=====================================================SELECT DOCTOR BASED ON DEPARTMENT SELECT===================================

if(isset($_GET['select_doc']))
{
    $val= $_GET["select_doc"];

    $val_M = mysqli_real_escape_string($connect, $val);

    $sql="SELECT doc_emailid FROM doctable WHERE specilaization='$val_M'";
    $result= mysqli_query($connect, $sql);

    if (mysqli_num_rows($result)>0) {

        echo "
        <label for='message-text' class='col-form-label'>Select Doctor:</label>
        <select class='form-control'name='doc_emailid'>
        <option style='width:280px;' disabled selected>--Select Doctor--</option>";
        while ($rows= mysqli_fetch_assoc($result)) {
        echo "<option style='width:280px;'  >".$rows["doc_emailid"]."</option>";
        }
        
        echo "</select>";
        
    } else {
        echo "
        <label for='message-text' class='col-form-label'>Select Doctor:</label>
        <select class='form-control'name='doc_emailid'>
        <option style='width:280px;'>--No Doctors--</option>
       </select>";
    }

}


//==============================================================PATIENT APPOINTMENT BOOKING=====================================================

if(isset($_POST['pat_bookappointment']))
{
$user_mailid=$_POST['u_mailid'];
$spec = $_POST['spec'];
$doc_emailid = $_POST['doc_emailid'];
$dis = $_POST['dis'];
$fees = $_POST['fees'];
$date = $_POST['date'];
$time = $_POST['time'];
$meeting_pref = $_POST['meeting_pref'];


$s = "select * from appointment";

$result = mysqli_query($connect, $s);

$num = mysqli_num_rows($result);


    
    $reg="insert into appointment(user_emailid,doc_emailid,specialization,disease,consultancyfees,appointmentdate,appointmenttime,userstatus,doctorstatus,meeting_preference) values ('$user_mailid','$doc_emailid','$spec','$dis','$fees','$date','$time','1','1','$meeting_pref')";
    mysqli_query($connect,$reg);

	echo '<script>alert("Your Appointment successfully Booked wait for the doctor responce")</script>';
	?>
	<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../pat_appointmentlist.php">
	<?php
}

// PATIENT APPOINTMENT STATUS - CANCEL APPOINTMENT
if(isset($_POST['pat_appointmentcancel']))
{
$Sno = (isset($_POST['SNo']) ? $_POST['SNo'] : 'error');

        $reg="update  appointment set userstatus='0' where sno='$Sno'";
        $data=mysqli_query($connect,$reg);
        if($data)
        {
            
            echo"<script>window.alert('Your Appointment Has Been Successfully Canceled')</script>";
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../pat_appointmentlist.php">
            <?php

        }
        else
        {
        echo"<script>window.alert('Failed to Cancel Your Appointment')</script>";
        ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../pat_appointmentlist.php">
            <?php

        }
}


	
//==============================================================SELECT APPOINTMENT TIME BASED ON DEPARTMENT SELECT=====================================================

if(isset($_GET['select_time']))
{
    $val= $_GET["select_time"];
    $val_M = mysqli_real_escape_string($connect, $val);

    $sql="SELECT depart_mrgtime,depart_evetime FROM department WHERE depart_name='$val_M'";
    $result= mysqli_query($connect, $sql);

    if (mysqli_num_rows($result)>0) {

        while ($rows= mysqli_fetch_assoc($result)) {
			echo ' 
			<label for="message-text" class="col-form-label">Select Appointment time :</label>  
			<select name="time" class="form-control" required>
            	<option value="" disabled selected>--Select Time--</option>
                    <optgroup label="Morning Time">
                        <option value="'.$rows['depart_mrgtime'].'">'.$rows['depart_mrgtime'].'</option>
                    </optgroup>
                    <optgroup label="Evening Time">
                        <option value="'.$rows['depart_evetime'].'">'.$rows['depart_evetime'].'</option>
                    </optgroup>
            </select>                     
			';
        }
        
        echo "</select>";
        
    } else {
		echo '   
		<label for="message-text" class="col-form-label">Select Appointment time :</label>  
			<select name="time" class="form-control"  required>
            	<option value="" disabled selected>--Select Time--</option>
                    <optgroup label="Morning Time">
                        <option value="">Data Not found</option>
                    </optgroup>
                    <optgroup label="Evening Time">
                        <option value="">Data Not found</option>
                    </optgroup>
            </select>                     
			';
    }

}
?>

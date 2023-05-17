<?php
include('../../includes/db_connect.php');

//===============================================================DOCTOR LOGIN=====================================================

if (isset($_POST['doc_login'])){

    session_start(); 
    
    $mail = $_POST['doc_email'];
    $docpassword = $_POST['doc_password'];

    $s = "select * from  doctable where doc_emailid='$mail' AND password='$docpassword'";
    $result = mysqli_query($connect, $s);

    $num = mysqli_num_rows($result);
    if($num > 0)
    {
        $_SESSION['mail']=$mail;
        header('location:../doc_home.php');
    }
    else
    {
        header('location:../../loginfail.html');
    }
}


//===============================================================DOCTOR USER APPOINTMENT ACCEPT=====================================================

if(isset($_POST['user_appointment_accept']))
{
    $Sno = (isset($_POST['SNo']) ? $_POST['SNo'] : 'error');
       $query1="UPDATE appointment SET doctorstatus ='2' WHERE sno='$Sno'";
       echo "<script>window.alert('Appointment Accepted')</script>";
	   ?>
	   <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../doc_appointmentlist.php">
	   <?php
       mysqli_query($connect,$query1);
}

//===============================================================DOCTOR USER APPOINTMENT REJECT=====================================================

if(isset($_POST['user_appointment_reject']))
{ 
    $Sno = (isset($_POST['SNo']) ? $_POST['SNo'] : 'error');
       $query2="UPDATE appointment SET doctorstatus ='0' WHERE sno='$Sno'";
        echo "<script>window.alert('Appointment Rejected')</script>";
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../doc_appointmentlist.php">
		<?php
        mysqli_query($connect,$query2);
}


//===============================================================DOCTOR PRESCRIPTION SEND=====================================================

if(isset($_POST['doc_prescriptionsend']))
{ 
    session_start();

    $doc_mail= $_POST['doc_mail'];
    $user_mail= $_POST['user_mail'];
    $fname= $_POST['fname'];
    $mobile= $_POST['mobileno'];
    $adate= $_POST['adate'];
    $atime= $_POST['atime'];
    $gender = $_POST['gen'];
    $disease = $_POST['dis'];
    $medicine = $_POST['medicine'];
    $meet = $_POST['meet'];
    $message = $_POST['message'];
    $cfees = $_POST['cfees'];

            $reg="insert into prescription(doc_emailid,fullname,user_emailid,mobile,adate,atime,gender,cfees,disease,medicine,meet,message,status) values ('$doc_mail','$fname','$user_mail','$mobile','$adate','$atime','$gender','$cfees','$disease','$medicine','$meet','$message','0')";
            mysqli_query($connect,$reg);
            echo "<script>window.alert('Prescription Successfully Sended')</script>";
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../doc_preslist.php">
            <?php
}

//===============================================================DOCTOR PRESCRIPTION DELETE=====================================================

if(isset($_POST['doc_prescriptiondelete']))
{ 

    $sno=$_POST['sno'];
    $query="DELETE FROM prescription WHERE sno='$sno'";
    $data=mysqli_query($connect,$query);
        
    if($data)
    {
        echo"<script>window.alert('Prescription successfully deleted')</script>";
    ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../doc_preslist.php">
        <?php
    }
    else
    {
    echo"<script>window.alert('Failed to delete the prescription')</script>";	
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../doc_preslist.php">
    <?php
    }
}

?>
<?php

include('../../includes/db_connect.php');
//===============================================================ADMIN LOGIN=====================================================

if(isset($_POST['admin_login']))
{
	session_start();
	$userid = $_POST['admin_emailid'];
	$password = $_POST['admin_password'];

		if($userid=='admin@gmail.com' && $password=='admin@123')
		{
		    $_SESSION['username']=$userid;
		   header('location:../admin_home.php');
		}
	    else
		{
			header('location:../../loginfail.html');
		}
}

//===============================================================ADMIN APPOINTMENT DELETE=====================================================

if (isset($_POST['admin_appointmentdelete']))
{
	$sno=$_POST['Sno'];
	$query="DELETE FROM appointment WHERE sno='$sno'";
	$data=mysqli_query($connect,$query);
	
	if($data)
	{
		
		echo"<script>window.alert('Appointment deleted successfully')</script>";
	?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_expiredlist.php">
		<?php
	}
	else
	{
	echo"<script>window.alert('Failed to delete the appointment')</script>";	
	?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_expiredlist.php">
		<?php
	
	}
}




//===============================================================ADMIN DOCTOR DELETE=====================================================

if (isset($_POST['admin_docdelete']))
{
	$doc_emailid=$_POST['doc_emailid'];
	$query="DELETE FROM doctable WHERE doc_emailid='$doc_emailid'";
	$data=mysqli_query($connect,$query);
	
if($data)
{
	
	echo"<script>window.alert('Doctor deleted successfully')</script>";
?>
	<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_doclist.php">
	<?php
}
else
{
 echo"<script>window.alert('Failed to delete the Doctor')</script>";	
 ?>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_doclist.php">
	<?php
}
}


//===============================================================ADMIN PATIENT DELETE=====================================================

if (isset($_POST['admin_patientdelete']))
{
	
	$emailid=$_POST['email'];
	$query="DELETE FROM pattable WHERE email='$emailid'";
	$data=mysqli_query($connect,$query);
	
    

if($data)
{
	
	echo"<script>window.alert('Patient deleted successfully')</script>";
	?>
	<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_patlist.php">
	<?php
}
else
{
 echo"<script>window.alert('Failed to delete the patient')</script>";	
 ?>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_patlist.php">
 <?php
}
}

//===============================================================ADMIN ADD DOCTOR=====================================================

if (isset($_POST['admin_adddoctor']))
{
	$doc_emailid= $_POST['doctor_emailid'];
	$docname= $_POST['doctorname'];
	$docnum=$_POST['docnum'];
	$docgender=$_POST['docgender'];
	$spec = $_POST['spec'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
	$fees = $_POST['fees'];


	if($password != $cpassword){
	echo "<script>alert('password & confirm password is mismatching.... please re-enter your password ');</script>";
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_add_doc.php">
		<?php
		
	}
	else{
	$s = "select * from doctable where doc_emailid='$doc_emailid'";

	$result = mysqli_query($connect, $s);

	$num = mysqli_num_rows($result);

	if($num==1)
	{
		echo "<script>window.alert('Doctor emailid is already taken');</script>";
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_doclist.php">
		<?php
		
	}
	else
	{
		$reg="insert into doctable(`doc_emailid`,`docname`,`docnum`,`docgender`,`specilaization`,`password`,`confirmpassword`,`consultancyfees`) values ('$doc_emailid','$docname','$docnum','$docgender','$spec','$password','$cpassword','$fees')";
		mysqli_query($connect,$reg);
		
		echo"<script>window.alert('Doctor Successfully Added');</script>"; 
		
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_doclist.php">
		<?php
		
	}
	}
}

//===============================================================ADMIN ADD DEPARTMENT=====================================================

if (isset($_POST['admin_adddepartment']))
{
	$depart_name=$_POST['add_departname'];

	$depart_para1=$_POST['depart_para1'];
	$depart_para2=$_POST['depart_para2'];
	$depart_mrg=$_POST['depart_mrgtime'];
	$depart_eve=$_POST['depart_evetime'];
	
	$amt=$_POST['depart_amt'];

	$fileElementName = 'file';
	$path = '../../assets/images&gif/Departments/'; 
	$location = $path.$_FILES['Department_image']['name']; 
	$image = $path.$_FILES['Department_image']['name']; 
	$depart_img=$_FILES['Department_image']['name'];
	if($depart_name==''|| $depart_para1==''||$depart_para2==''){
		echo "<script>alert('Some Fields are not entered Please check !!!') </script>";
		?>
			<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
		<?php
	}
	else{
		if($image=='')
		{
			echo "<script>alert('please select Department image ') </script>";
		}
		else{
			$s = "select * from department where depart_name='$depart_name'";
			$result = mysqli_query($connect, $s);
			$num = mysqli_num_rows($result);
			if($num==1)
			{
				echo '<script>alert("Department already Exists")</script>';
				?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
				<?php
			}
			else
			{
				$adddepart="insert into department(`depart_name`,`depart_img`,`depart_para1`,`depart_para2`,`depart_amt`,`depart_mrgtime`,`depart_evetime`) values ('$depart_name','$depart_img','$depart_para1','$depart_para2','$amt','$depart_mrg','$depart_eve')";
				mysqli_query($connect,$adddepart);
				move_uploaded_file($_FILES['Department_image']['tmp_name'],$location);
				echo '<script>alert("Department Added Successfully")</script>';
				// echo $depart_name.$depart_img.$depart_mrg.$depart_eve.$depart_para1.$depart_para2;
				?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
				<?php
			}	
		}
   	}  
}

	
//===========================================SELECT CONSULTANCY FEES BASED ON DEPARTMENT SELECT===================================

if(isset($_GET['select_depart']))
{
    $val= $_GET["select_depart"];
    $val_M = mysqli_real_escape_string($connect, $val);

    $sql="SELECT depart_amt FROM department WHERE depart_name='$val_M'";
    $result= mysqli_query($connect, $sql);

    if (mysqli_num_rows($result)>0) {

        while ($rows= mysqli_fetch_assoc($result)) {
			echo ' 
			<label for="message-text" class="col-form-label">Doctor Consultacy Fees :</label>                       
			<input type="hidden" class="form-control" placeholder="Enter the Doctor Fees" name="fees" id="fees" value="'.$rows["depart_amt"].'" readonly>
			<input type="text" class="form-control" placeholder="Rs '.$rows["depart_amt"].'/- " readonly>
			';
        }
        
        echo "</select>";
        
    } else {
		echo '   
		<label for="message-text" class="col-form-label">Doctor Consultacy Fees :</label>                     
		<input type="text" class="form-control" placeholder="Enter the Doctor Fees" name="fees" id="fees" value="Department Not Found" readonly>
		';
    }

}



	
//===============================================================ADMIN DEPARTMENT DELETE=====================================================

if (isset($_POST['admin_departdelete']))
{
	$id=$_POST['id'];
	$query="DELETE FROM department WHERE id='$id'";
	$data=mysqli_query($connect,$query);
	
	if($data)
	{
		
		echo"<script>window.alert('Department deleted successfully')</script>";
	?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
		<?php
	}
	else
	{
	echo"<script>window.alert('Failed to delete the Department')</script>";	
	?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
		<?php
	
	}
}

//===============================================================ADMIN DEPARTMENT EDIT=====================================================

if (isset($_POST['admin_editdepartment']))
{
	$depart_id=$_POST['edit_id'];
	$depart_name=$_POST['edit_departname'];

	$depart_para1=$_POST['edit_depart_para1'];
	$depart_para2=$_POST['edit_depart_para2'];
	$depart_mrg=$_POST['edit_depart_mrgtime'];
	$depart_eve=$_POST['edit_depart_evetime'];
	
	$amt=$_POST['edit_depart_amt'];

	$fileElementName = 'file';
	$path = '../../assets/images&gif/Departments/'; 
	$location = $path.$_FILES['Edit_Department_image']['name']; 
	$image = $path.$_FILES['Edit_Department_image']['name']; 
	$depart_img=$_FILES['Edit_Department_image']['name'];
	if($depart_name==''|| $depart_para1==''||$depart_para2==''||$depart_mrg==''||$depart_eve==''){
		echo "<script>alert('Some Fields are not entered Please check !!!') </script>";
		?>
			<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
		<?php
	}
	else{
		if($image=='')
		{
			echo "<script>alert('please select Department image ') </script>";
		}
		else{
			$reg1="update department set depart_name='$depart_name',depart_para1='$depart_para1',depart_para2='$depart_para2',depart_amt='$amt',depart_mrgtime='$depart_mrg',depart_evetime='$depart_eve' where id='$depart_id'";
			$data1=mysqli_query($connect,$reg1);
			
			if($data1)
			{
				$reg2="update doctable set consultancyfees='$amt' Where specilaization='$depart_name'";
				$data2=mysqli_query($connect,$reg2);
				if($data2){
					echo"<script>window.alert('Department Updated Successfully')</script>";
					?>
					<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
					<?php
				}
				else{
					echo"<script>window.alert('Failed to Update Department in doctor')</script>";
					?>
					<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
					<?php
					}

			}
			else
			{
				echo"<script>window.alert('Failed to Update Department')</script>";
				?>
				<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../admin_departlist.php">
				<?php

			}
		}
   	}  
}

?>

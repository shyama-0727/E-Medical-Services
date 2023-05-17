<?php
include('includes/db_connect.php');
$depart_name= $_GET['name'];
$query = "SELECT * FROM `department` where depart_name='$depart_name'";

$query_run= mysqli_query($connect,$query);
$depart_img='';$depart_para1='';$depart_para2='';
while($row=mysqli_fetch_array($query_run)){
    $depart_img=$row['depart_img'];
    $depart_para1=$row['depart_para1'];
    $depart_para2=$row['depart_para2'];
}
?>
<?php include('includes/header.php');?>
<body>
    <!-- As a link -->
    <nav class="navbar navbar-light bg-light sticky-top">
        <a class="navbar-brand" href="index.php"><i class="fas fa-backward"></i> Back</a>
    </nav>
  
    <div class="container-fluid bg-1 text-center">
        <h3 class="margin"><?php echo $depart_name;?></h3>
        <?php echo'
                <img src="assets/images&gif/Departments/'.$depart_img.'"class="img-responsive img-circle margin" alt="img not found" >
                <p>Exellence in patient care, research, and education is the overall goal of the Department of '.$depart_name.' at WECARE HOSPITAL . <br>	The Department of '.$depart_name.' surgery provides a comprehensive and integrated'.$depart_name.' program for patients, students, residents, and fellows .</p>
                <div class="container-fluid bg-2 text-center">
                <h4>'.$depart_name.'</h4>
                <p>'.$depart_para1.'</p>
                <br>
                <h4>Department - '.$depart_name.'</h4>
                <p>'.$depart_para2.'</p>
            </div>
        '
        ?>
    </div>
    <?php include('includes/footer.php');?>
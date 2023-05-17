<?php
include('../includes/db_connect.php');

session_start(); 
 if(!isset($_SESSION['email']))
    {
        header('location:../pat_doc_signin.html');
    }
    else{
$loggeduser_email=$_SESSION['email'];

$query= "SELECT * FROM pattable where email='$loggeduser_email'";
$query_run= mysqli_query($connect, $query);   
while($row=mysqli_fetch_array($query_run)){
    $loggeduser_name=$row['fullname'];
    $loggeduser_phone=$row['phoneno'];
    $loggeduser_password=$row['password'];
    $loggeduser_gender=$row['gender'];
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E MEDICAL SERVICES</title>

    <!-- Title icon -->
    <link rel="icon" href="../assets/images&gif/others/logo.jpg">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <!--Css Stylesheets-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/after_login.css">
    <link rel="stylesheet" href="../assets/css/tables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--FontAwesome-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
</head>

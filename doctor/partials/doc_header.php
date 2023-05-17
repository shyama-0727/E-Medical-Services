<?php
include('../includes/db_connect.php');

session_start(); 
 if(!isset($_SESSION['mail']))
    {
        header('location:../pat_doc_signin.html');
    }
    else{
$loggeddoc_email=$_SESSION['mail'];

$query= "SELECT * FROM doctable where doc_emailid='$loggeddoc_email'";

$query_run= mysqli_query($connect, $query);
 
while($row2=mysqli_fetch_array($query_run)){

    $loggeddoc_name=$row2['docname'];

    $loggeddoc_phone=$row2['docnum'];
    $loggeddoc_password=$row2['password'];
    $loggeddoc_spec=$row2['specilaization'];
    $loggeddoc_gender=$row2['docgender'];
    $loggeddoc_confees=$row2['consultancyfees'];
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
    <link rel="stylesheet" href="../assets/css/signup.css">
    
    <!--FontAwesome-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
</head>

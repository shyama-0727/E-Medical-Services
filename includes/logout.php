<?php
session_start();
$LoggedUser=$_GET['user'];
if($LoggedUser=='admin'){
    session_destroy();
    header('location:../admin_signin.html');
}
else{
    session_destroy();
    header('location:../pat_doc_signin.html');
}
?>

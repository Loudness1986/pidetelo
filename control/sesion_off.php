<?php
session_start();
if(!isset($_SESSION)) {
    header("location:../index.php");
}
else {
    session_destroy();
    session_unset();
    header("Location:../index.php");
}
?>

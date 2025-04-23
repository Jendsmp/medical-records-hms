<?php
    session_start();
    include('includes/dbconnection.php');

    session_unset();
    session_destroy();

    header("Location: index.php");
exit();
?>
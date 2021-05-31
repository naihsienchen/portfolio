<?php

session_start();

if (isset($_SESSION['userID'])) {
    unset($_SESSION['userID']);
    unset($_SESSION['userEmail']);
    unset($_SESSION['userFirstName']);
    unset($_SESSION['userLastName']);
    header('Location: index.php');
}
header('Location: index.php');
?>
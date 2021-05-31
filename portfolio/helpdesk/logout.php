<?php
session_start();
//unset($_SESSION['username']);
session_destroy();
echo "logged out";
//redirect to login page doesn't work
header('location: index.php');
//exit();
include 'views/header.php';
?>

    <h3><a href="login.php">back to log in</a></h3>

<?php
include 'views/footer.php';
?>

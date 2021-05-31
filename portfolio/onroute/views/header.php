<!--Header-->
<?php
session_start();

//Header menu associative array
$headerMenu = [
    'Home' => 'index.php',
    'Flights' => 'flights.php',
    'Accommodations' => 'accommodations.php',
    'Vehicle Rental' => 'vehicles.php',
    'Customer Service' => 'services.php'
];

//Initialize login/logout section of menu
$loginMenu = [];

//Checks if user is logged in, displays appropriate interface
if (isset($_SESSION['userID'])) {
    $loginMenu[$_SESSION['userFirstName'] . " " .  $_SESSION['userLastName']] = "myaccount.php";
    $loginMenu['Logout'] = 'logout.php';
} else {
    $loginMenu['Login'] = 'login.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<div class="page">
    <head>
        <meta charset="utf-8" />
        <title>onRoute - Travel Better</title>
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <link type="text/css" rel="stylesheet"  href="styles/global.css" />
        <?php
        //Allows for custom css files to be linked to each inidividual page
            if (isset($css) && is_array($css))
            foreach ($css as $path)
                printf('<link rel="stylesheet" type="text/css" href="%s" />', $path);
        ?>
        <script src="https://kit.fontawesome.com/2956115494.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <h1><a href="index.php" class="homeLink">onRoute <i class="fas fa-route"></i></a></h1>
            <nav>
                <?php echo displayNavigation($headerMenu) . displayNavigation($loginMenu); ?>
            </nav>
        </header>
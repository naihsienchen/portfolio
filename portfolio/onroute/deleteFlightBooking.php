<?php
    use ONROUTE\models\{Database,Flight};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    $css = array("styles/flightBooking.css");//Add unqiue css files here
    require_once 'views/header.php';

    //Checks if user is logged in
    if (empty($_SESSION['userID'])) {
        //Redirects to login page if user is not logged in
        Header('Location: login.php');
    }

    //Initialize variables for toggling display information
    $redirect = "";
    $hide = "";

    //Instantiate database connection
    $db = Database::getDb();
    
    //Checks if $_POST value exist to see if user accessed page through myaccount.php redirect
    if (empty($_POST)) {
        $redirect = "style='display:block;'";
        $hide = "style='display:none'";
    }
    else{
        $redirect = "style='display:none;'";
        $flightBookingId = $_POST['flightBookingId'];
    
    //If flight number exisit (from flights.php page), utilize getFlightById to get the flight details
    $flightController = new Flight($db);

    //send flightId to controller 
    $flightDetails = $flightController->getFlightDetailsByBookingId($flightBookingId);
    }

    //Executes if "Delete Flight" button is clicked
    if (isset($_POST['deleteFlightBooking'])){
        $finalFlightBookingId = $_POST['flightBookingId'];//Saves flightBookingId as a POST data

        $flightController = new Flight($db);

        //Delete flight booking from flightbookings table given the specific bookingid
        $deleteBooking = $flightController->deleteFlightBooking($finalFlightBookingId);
        
        header("Location: myaccount.php");
    }

?>

<main>
    <div class = "flightSelected">
        <h2 class="emptyMsg" <?= $redirect ?>> Looking to cancel a flight? </br> Click <a href="./myaccount.php">Here</a></h3> 
        <h2 <?= $hide ?>>Flight Details </h2>
        <div class="flightSelected__details">
            <ul>
                <?php 
                    if (isset($flightDetails)){
                ?>
                    <li><span class="listTitle">Depature Airport: </span> <?=  $flightDetails->departureairport; ?></li>
                    <li><span class="listTitle">Arrival Airport: </span><?=  $flightDetails->arrivalairport; ?></li>
                    <li><span class="listTitle">Depature Date: </span><?=  $flightDetails->departuredate; ?></li>
                    <li><span class="listTitle">Depature Date: </span><?=  $flightDetails->arrivaldate; ?></li>
                    <li><span class="listTitle">Airlines:</span> <?=  $flightDetails->airlinename; ?></li>
            </ul>
            <h3>Are you sure you want to cancel this flight booking? <br> <span class='warning'>WARNING: This action cannot be undone.</span></h3>
            <div class="flightSelected__details_btns">
                <a href="./myaccount.php" class="bookBtn">Cancel<a>
                <form action="" method="POST">
                        <input type="hidden" name="flightBookingId" value=" <?= $flightDetails->id; ?>"/>
                        <button type="submit" class="deleteBtn" name="deleteFlightBooking">Delete Booking</button>
                </form>
            </div>
            <?php 
                } 
                ?>
        </div>
    </div>
</main>

<?php
require_once 'views/footer.php';
?>
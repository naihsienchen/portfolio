<?php
    use ONROUTE\models\{Database,Hotel};
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
        $hotelBookingId = $_POST['hotelBookingId'];
    
    //If hotel number exisit (from acccomodation.php page), utilize getHotelById to get the accomodation details
    $hotelController = new Hotel($db);

    //send hotelId to controller 
    $hotelDetails = $hotelController->getHotelById($db);
    }

    //Executes if "Delete Hotel" button is clicked
    if (isset($_POST['deleteHotelBooking'])){
        $finalHotelBookingId = $_POST['hotelBookingId'];//Saves hotelBookingId as a POST data

        $hotelController = new Hotel($db);

        //Delete hotel booking from hotelbookings table given the specific bookingid
        $deleteBooking = $hotelController->deleteHotelBooking($finalHotelBookingId, $db);
        
        header("Location: myaccount.php");
    }

?>

<div class = "flightSelected">
    <h2 class="emptyMsg" <?= $redirect ?>> Looking to cancel a accomodation? </br> Click <a href="./myaccount.php">Here</a></h3> 
    <h2 <?= $hide ?>>Hotel Details </h2>
    <div class="flightSelected__details">
        <ul>
            <?php 
                if (isset($hotelDetails)){
            ?>
                <li><span class="listTitle">Hotel Name: </span> <?=  $hotelDetails->hotelname; ?></li>
                <li><span class="listTitle">Hotel Address: </span><?=  $hotelDetails->hoteladdress; ?></li>
                <li><span class="listTitle">Check In Date: </span><?=  $hotelDetails->checkintime; ?></li>
                <li><span class="listTitle">Check Out Date: </span><?=  $hotelDetails->checkouttime; ?></li>
        </ul>
        <h3>Are you sure you want to cancel this accomodation booking? <br> <span class='warning'>WARNING: This action cannot be undone.</span></h3>
        <div class="flightSelected__details_btns">
            <a href="./myaccount.php" class="bookBtn">Cancel<a>
            <form action="" method="POST">
                    <input type="hidden" name="hotelBookingId" value=" <?= $hotelDetails->id; ?>"/>
                    <button type="submit" class="deleteBtn" name="deleteHotelBooking">Delete Booking</button>
            </form>
        </div>
        <?php 
            } 
            ?>
    </div>
</div>

<?php
require_once 'views/footer.php';
?>
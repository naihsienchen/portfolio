<?php
    use ONROUTE\models\{Database,Vehicle};
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
        $vehicleRentalId = $_POST['vehicleRentalId'];
    
    //If vehicle number exisit (from myaccount.php page), utilize getVehicleRentalByBookingId to get the vehicle details
    $vehicleController = new Vehicle($db);

    //send vehicleid to controller 
    $vehicleDetails = $vehicleController->getVehicleRentalByBookingId($vehicleRentalId, $db);
    }

    //Executes if "Delete Vehcile" button is clicked
    if (isset($_POST['deleteVehicleRental'])){
        $finalVehicleRentalId = $_POST['vehicleRentalId'];//Saves vehicleRentalId as a POST data

        $vehicleController = new Vehicle($db);

        //Delete vehicle rental from vehiclerentals table given the specific rentalid
        $deleteRental = $vehicleController->deleteVehiclesToRent($finalVehicleRentalId, $db);
        
        header("Location: myaccount.php");
    }

?>

<div class = "flightSelected">
    <h2 class="emptyMsg" <?= $redirect ?>> Looking to cancel a vehicle rental? </br> Click <a href="./myaccount.php">Here</a></h3> 
    <h2 <?= $hide ?>>Vehicle Details </h2>
    <div class="flightSelected__details">
        <ul>
            <?php 
                if (isset($vehicleDetails)){
            ?>
                <li><span class="listTitle">Model: </span> <?=  $vehicleDetails[0]->vehiclemodel; ?></li>
                <li><span class="listTitle">Make: </span><?=  $vehicleDetails[0]->vehiclemake; ?></li>
                <li><span class="listTitle">Price/day: $</span><?=  $vehicleDetails[0]->vehicleprice; ?></li>
                <li><span class="listTitle">Rental Company: </span><?=  $vehicleDetails[0]->rentalcompanyname; ?></li>
                <li><span class="listTitle">Address: </span><?=  $vehicleDetails[0]->rentalcompanyaddress; ?></li>
                <li><span class="listTitle">Pick Up Date: </span><?=  $vehicleDetails[0]->pickupdate; ?></li>
                <li><span class="listTitle">Return Date: </span><?=  $vehicleDetails[0]->returndate; ?></li>
        </ul>
        <h3>Are you sure you want to cancel this vehicle rental? <br> <span class='warning'>WARNING: This action cannot be undone.</span></h3>
        <div class="flightSelected__details_btns">
            <a href="./myaccount.php" class="bookBtn">Cancel<a>
            <form action="" method="POST">
                    <input type="hidden" name="vehicleRentalId" value=" <?= $vehicleDetails[0]->id; ?>"/>
                    <button type="submit" class="deleteBtn" name="deleteVehicleRental">Delete Rental</button>
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
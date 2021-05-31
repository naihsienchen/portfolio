<?php
use ONROUTE\models\{Database, Vehicle};
require_once 'vendor/autoload.php';
require_once 'library/functions.php';
require_once 'library/vehicles.php';
//Styling and Header View
$css = array('styles/vehicles.css');
require_once 'views/header.php';
//variable. 
$appear = 'style="display: block;';
$disappear = 'style="display: none;"';
$timed;
//vehicle data picked by id
//getting the information from the database
$dbcon = Database::getDb();
$vh = new Vehicle();
$id = $_GET["id"];
$vehicles = $vh->getVehiclesById($id, $dbcon);
//Collect rental id foro function
foreach($vehicles as $vehicleInfo){
    //putting the rental compnay id into a variable
    $rcid = $vehicleInfo->rentalcompany_id;
    //getting the information from the database
    $dbcon = Database::getDb();
    $rc = new Vehicle();
    $rcompanies = $rc->getRentalCompanies($rcid, $dbcon);
}
//If sessions are set then retrieve them.
if(isset($_SESSION['pDate']) && isset($_SESSION['rDate'])){
    //div styling uppon submision
    $appear = 'style="display: none"';
    $disappear = 'style="display: block;"';
    //date formatting.
    $origin = new DateTime($_SESSION['rDate']);
    $target = new DateTime($_SESSION['pDate']);
    $interval = $origin->diff($target);
    $timed = $interval->format('%a');
    //On susbmit insert into vehiclerentals table
    if(isset($_POST['vehicle-confirm'])){
        foreach($rcompanies as $rcompany){

            $vehicleLoc = $rcompany->rentalcompanyaddress;
            $pickUp = $_SESSION['pDate'];
            $return = $_SESSION['rDate'];
            $userId = $_SESSION['userID'];

            $dbcon = Database::getDb();
            $av = new Vehicle();
            $addVehicle = $av->addVehiclesToRent($vehicleLoc, $pickUp, $return, $id, $userId, $dbcon);
            header("Location: vehicles.php");
        }
    }
} else /*if sessions are not set...Select the values*/ {
    if(isset($_GET['submitDate'])){
        //collect all form input elements and validate.
        $pickupDate = $_GET['puDate'];
        $returnDate = $_GET['rDate'];
        //If statements to check the inputs
        if(empty($pickupDate)){
            $ErrorMsg = 'Pick up date must be filled';
        }
        else if(empty($returnDate)){
            $ErrorMsg = 'Return date must be filled';
        } 
        elseif(isset($_GET['puDate']) && isset($_GET['rDate'])) {
            $dbcon = Database::getDb();
            $viewDate = new Vehicle();
            $selectedDate = $viewDate->GetSelectedDate($pickupDate, $returnDate, $id, $dbcon);
            if($selectedDate == true){
                $ErrorMsg = "Vehicle has already been chosen, pick another date";
            } else {
                //div styling uppon submision
                $appear = 'style="display: none"';
                $disappear = 'style="display: block;"';
                //date formatting.
                $origin = new DateTime($returnDate);
                $target = new DateTime($pickupDate);
                $interval = $origin->diff($target);
                $timed = $interval->format('%a');
                //On susbmit insert into vehiclerentals table
                if(isset($_POST['vehicle-confirm'])){
                    foreach($rcompanies as $rcompany){

                        $vehicleLocation = $rcompany->rentalcompanyaddress;
                        $userId = $_SESSION['userID'];
                        $id = $_GET['id'];

                        $dbcon = Database::getDb();
                        $viewDate = new Vehicle();
                        $selectedDate = $viewDate->addVehiclesToRent($vehicleLocation, $pickupDate, $returnDate, $id, $userId, $dbcon);
                        $notAccepted = "Approved";
                        header("Location: vehicles.php");
                    }
                }
            }
        }
    }
}
?>

<main class="infield">
<?php if(isset($_SESSION['userID'])){?>
    <a href="vehicles.php" id="return-button">Go Back</a>
    <?php foreach($vehicles as $vehicle){ ?>
        <h2><?= $vehicle->vehiclemake. ' ' .$vehicle->vehiclemodel ?></h2>
        <!-- SELECTED -->
        <div class="selected">
            <img src="images/vehicles/<?= $vehicle->vehicleimage; ?>" height="250" alt="Image of a car model"/>
            <div>
                <?php foreach($rcompanies as $rcompany){ ?>
                    <p>Company Name: <span class="text-span"><?= $rcompany->rentalcompanyname ?></span></p>
                    <p>Pick Up Address: <span class="text-span"><?= $rcompany->rentalcompanyaddress ?></span></p>
                <?php } ?>
                <p>City: <span class="text-span"><?= $vehicle->vehiclecity; ?></span></p>
                <p>Price: CAD $<span class='text-span'><?= $vehicle->vehicleprice ?>/Day</span></p>
                <p <?= $disappear; ?>>Total: CAD <span class='text-span'>$<?= addPrice($vehicle->vehicleprice, $timed) ?>.00</span> for <?= $timed + 1 ?> Days.</p>
            </div>
        </div>
        <div <?= $appear; ?> >
            <h2>Select a pick up date & return date.</h2>
            <div id="form-display">
                <form action="#form-date" method="GET" name="form" id="form-date">
                    <div class="form__input">
                        <label>Pick Up Date</label>
                        <input type="date" name="puDate" id="puDate" value="<?= isset($pickupDate)? $pickupDate: '';?>"/>
                    </div>
                    <div class="form__input">
                        <label>Return Date</label>
                        <input type="date" name="rDate" id="rDate" value="<?= isset($returnDate)? $returnDate: '';?>"/>
                    </div>
                    <input type="hidden" name="id" value="<?= $_GET["id"]; ?>"/>
                    <div class="form__input">
                        <input class="form__submit_btn" name="submitDate" type=submit value="Submit"/>
                    </div>
                    <span id="error-msg"><?= isset($ErrorMsg)? $ErrorMsg: '';?></span>
                </form>
            </div>
        </div>
    <?php } if(isset($pickupDate) && isset($returnDate) || isset($_SESSION['pDate']) && isset($_SESSION['rDate'])){ ?>
    <form method="POST" action="#">
        <div class="submit__input">
            <input type="submit" class="confirmOrder" name="vehicle-confirm" value="Confirm Rental"/>
        </div>
        <span id="error-msg"><?= isset($notAccepted)? $notAccepted: '';?></span>
    </form>
<?php }} else { header('Location: ./login.php'); } ?>
</main>

<?php
require_once 'views/footer.php';
?>
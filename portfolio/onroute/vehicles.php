<?php
session_start();
use ONROUTE\models\{Database, Vehicle};
require_once 'vendor/autoload.php';
require_once 'library/functions.php';
require_once 'library/vehicles.php';
//Styling and Header View
$css = array('styles/vehicles.css');
require_once 'views/header.php';
//variables. 
$displayVehicles;
$appear = 'style="display: block;';
$disappear = 'style="display: none;"';
$timed;
//Checking on form submission.
if(isset($_POST['vehicleSubmit'])){
    //collect all form input elements and validate.
    $pickupLoc = $_POST['puLocation'];
    $pickupDate = $_POST['puDate'];
    $returnDate = $_POST['rDate'];

    if(empty($pickupLoc)){
        $ErrorMsg = 'Pick up location must be filled';
    }
    else if(empty($pickupDate)){
        $ErrorMsg = 'Pick up date must be filled';
    }
    else if(empty($returnDate)){
        $ErrorMsg = 'Return date must be filled';
    } 
    else {
        //getting all vehicle information where location matches user input.
        $dbcon = Database::getDb();
        $vr = new Vehicle();
        $vrentals = $vr->SpecificCity($pickupLoc, $dbcon);
        //Sending information outside of parameters.
        $displayVehicles = $vrentals;
        //invert the display when user searches for vehicles.
        $appear = 'style="display: none';
        $disappear = 'style="display: block;"';
        if(isset($pickupDate) && $pickupDate !== "" && isset($returnDate) && $returnDate !== ''){
            $_SESSION['pDate'] = $pickupDate;
            $_SESSION['rDate'] = $returnDate;

            $origin = new DateTime($returnDate);
            $target = new DateTime($pickupDate);
            $interval = $origin->diff($target);
            $timed = $interval->format('%a');
        }
    }
}

if(empty($pickupDate) || empty($returnDate)){
    unset($_SESSION['pDate']);
    unset($_SESSION['rDate']);
}
//getting all vehicles from the database.
$dbcon = Database::getDb();
$vh = new Vehicle();
$vehicles = $vh->getAllVehicles($dbcon);
//var_dump($vehicles);
?>

<main class="infield">
    <a href="vehicleInfo.php" id="list-button">Rental List</a>
    <h2>Rent A Vehicle</h2>
    <!-- FORM -->
    <img src="images/vehicles/13-pexels-photo-4090350.jpeg" height="600" id="vehicle__image">
    <form action="#form" method="POST" name="form" id="form">
        <div class="form__input">
          <label>Pick Up Location</label>
          <input type="text" name="puLocation" id="puLocation" placeholder="City, Airport or Address" value="<?= isset($pickupLoc)? $pickupLoc: '';?>">
        </div>
        <div class="form__input">
           <label>Pick Up Date</label>
           <input type="date" name="puDate" id="puDate" value="<?= isset($pickupDate)? $pickupDate: '';?>"/>
        </div>
        <div class="form__input">
            <label>Return Date</label>
            <input type="date" name="rDate" id="rDate" value="<?= isset($returnDate)? $returnDate: '';?>"/>
        </div>
        <div class="form__input">
            <input class="form__submit_btn" name="vehicleSubmit" type=submit value="Search"/>
        </div>
        <span id="error-msg"><?= isset($ErrorMsg)? $ErrorMsg: '';?></span>
    </form>
    <div class="products">
        <h2>Choose Your Vehicle</h2>
            <?php echo '<div '.$appear.'"><div class="products__popular"><h3>Top Car Deals</h3>'; 
                foreach($vehicles as $vehicle){ if($vehicle->vehicleprice <= '65.00'){ ?>
                <div class="products__popular_opt">
                    <a href="./vehicleSelection.php?id=<?= $vehicle->id ?>" name="send-vehicle"><span class="deallabel">DEAL</span>
                        <p><?= $vehicle->vehiclemake.' '.$vehicle->vehiclemodel; ?></p><p><?= $vehicle->vehiclecity; ?></p><p>CAD $<?= $vehicle->vehicleprice; ?>/Day</p>
                        <img src="images/vehicles/<?= $vehicle->vehicleimage; ?>" height="200" alt="Image of a car model">
                    </a>
                </div>
            <?php }/*xif price deal statement*/}/*xforeach*/echo '</div></div>'?>
            <?php echo '<div '.$appear.'"><div class="products__popular"><h3>Vehicles Listed</h3>'; 
                foreach($vehicles as $vehicle){ ?>
                <div class="products__sytem_opt">
                    <a href="./vehicleSelection.php?id=<?= $vehicle->id ?>" name="send-vehicle">
                        <p><?= $vehicle->vehiclemake.' '.$vehicle->vehiclemodel; ?></p><p><?= $vehicle->vehiclecity; ?></p><p>CAD $<?= $vehicle->vehicleprice; ?>/Day</p>
                        <img src="images/vehicles/<?= $vehicle->vehicleimage; ?>" height="200" alt="Image of a car model">
                    </a>
                </div>
            <?php }/*xforeach*/echo '</div></div>'?>
            <?php echo '<div '.$disappear.'"><div class="products__popular"><h3>Vehicles Searched</h3>'; 
                foreach($displayVehicles as $vehicle){
                    $id = $vehicle->id;
                    $dbcon = Database::getDb();
                    $viewDate = new Vehicle();
                    $selectedDate = $viewDate->GetSelectedDate($pickupDate, $returnDate, $id, $dbcon);
                    if($selectedDate == false){
                ?>
                <div class="products__sytem_opt">
                    <a href="./vehicleSelection.php?id=<?= $vehicle->id ?>" name="send-vehicle">
                        <p class="short"><?= $vehicle->vehiclemake.' '.$vehicle->vehiclemodel; ?></p><p class="short"><?= $vehicle->vehiclecity; ?></p>
                        <p class="short">From: <?= date("M.d, Y", strtotime($pickupDate)); ?></p><p class="short">To: <?= date("M.d, Y", strtotime($returnDate)) ?></p>
                        <p class="short">Total: CAD $<?= addPrice($vehicle->vehicleprice, $timed); ?></p>
                        <img src="images/vehicles/<?= $vehicle->vehicleimage; ?>" height="200" alt="Image of a car model">
                    </a>
                </div>
            <?php }}/*xforeach*/echo '</div></div>'?>
        </div>
    </div>
</main>

<?php
require_once 'views/footer.php';
?>
<?php
use ONROUTE\models\{Database, Vehicle};
require_once 'vendor/autoload.php';
require_once 'library/functions.php';
require_once 'library/vehicles.php';
//Styling and Header View
$css = array('styles/vehicles.css');
require_once 'views/header.php';

$id = $_SESSION['userID'];
$dbcon = Database::getDb();
$vri = new Vehicle();
$rentalsById = $vri->getVehicleRentalByUser($id, $dbcon);
?>

<main class="infield">
<?php if(isset($_SESSION['userID'])){?>
    <a href="vehicles.php" id="list-button">Go Back</a>
    <h2>Rented Vehicle(s)</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Rental Information</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($rentalsById)){ 
                foreach($rentalsById as $vehicle){ ?>
                    <tr>
                        <td>
                            <p><img src="images/vehicles/<?= $vehicle->vehicleimage ?>" height="100"></p>
                            <p><strong>Pick Up Location: </strong><?= $vehicle->pickuplocation ?><p>
                            <p><strong>Pick Up Date: </strong><?= $vehicle->pickupdate ?></p>
                            <p><strong>Return Date: </strong><?= $vehicle->returndate ?></p>
                            <p><strong>Vehicle Make & Model: </strong><?= $vehicle->vehiclemake ?> <?= $vehicle->vehiclemodel ?></p>
                            <p><strong>Price/Day: </strong>CAD $<?= $vehicle->vehicleprice ?></p>
                            <p><strong>Total Price: </strong>
                            CAD $<?php
                                    $origin = new DateTime($vehicle->pickupdate);
                                    $target = new DateTime($vehicle->returndate);
                                    $interval = $origin->diff($target);
                                    $timed = $interval->format('%a');
                                    echo addPrice($vehicle->vehicleprice, $timed); 
                                ?>
                            </p>
                            <p><strong>Retnal Company: </strong><?= $vehicle->rentalcompanyname ?></p>
                            <p><strong>Rental Company Address: </strong><?= $vehicle->rentalcompanyaddress ?></p>
                        </td>
                        <td>
                            <!--Delete-->
                            <form action="./deleteVehicleRental.php" method="post">
                                <input type="hidden" name="vehicleRentalId" value="<?= $vehicle->id; ?>"/>
                                <input type="submit" class="button-delete" name="deleteData" value="Delete">
                            </form>
                        </td>
                    </tr>
            <?php }} ?>
        </tbody>
    </table>
<?php } else { header('Location: ./login.php'); } ?>
</main>

<?php
require_once 'views/footer.php';
?>
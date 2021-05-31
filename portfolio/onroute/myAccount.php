<?php
    use ONROUTE\models\{Database, Flight, Hotel, Vehicle};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    $css = array("styles/myAccount.css");
    require_once 'views/header.php';

    //Checks if user is logged in
    if (empty($_SESSION['userID'])) {
        //Redirects to login page if user is not logged in
        Header('Location: login.php');
    }

    //Checks dates
    $pastDate = "";
    $dateNow = new DateTime("NOW", new DateTimeZone('America/Toronto'));
    $date = date_format($dateNow, 'Y-m-d,  H:i:s');

    //Instantiate database
    $dbcon = Database::getDb();

    //Gets flight details
    $flightController = new Flight($dbcon);
    $flights = $flightController->getFlightBookingByUser($_SESSION['userID']);

    //Get hotel details
    $hotelController = new Hotel($dbcon);
    $hotels = $hotelController->getHotelBookingByUser($_SESSION['userID'],$dbcon);

    // //Get vehicle details
    $vehicleController = new Vehicle($dbcon);
    $vehicles = $vehicleController->getVehicleRentalByUser($_SESSION['userID'], $dbcon);


    //Taken from Will's section to allow for "View Details" button to work (adjustments made to fix context of feature)
    if(isset($_POST['flightSubmit'])){
            //get the flight id submitted and store as variable
            $flightId = $_POST['flightId'];

            //instantiate database connection
            $db = Database::getDb();
    
            //When flight number submitted, instantiate db connection, utilize getFlightById
            $flightController = new Flight($db);
    
            //send flightId to controller 
            $response = $flightController->getFlightById($flightId);
            
            if($response == false){
                $errMsg = "We couldn't find that flight. Did you double check your flight number?";
            } 
            else{
                switch($response->airline){
                    case 'aircanada':
                        $airlineLogoLink = 'images/logos/airCanada.jpg';
                        break;
                    case 'deltaAirlines';
                        $airlineLogoLink = 'images/logos/deltaAirlines.jpg';
                        break;
                    case 'americanAirlines';
                        $airlineLogoLink = 'images/logos/americanAirlines.jpg';
                        break;
                } 
                //store the $response as a session var
                $_SESSION['flightInfo'] = $response;
                $_SESSION['airlineLogoLink'] = $airlineLogoLink;
                //redirect user to the flightInfo pages
                header ('Location:flightInfo.php');   
            }
        }

?>


<main>
    <div class="page">
        <h2>Welcome <?= $_SESSION['userFirstName'] . " " . $_SESSION['userLastName'] . "!"?></h2>
        <div class="userDetails">
            <h3>Account Information <a href="accountManagement.php" class="accountBtn" >Manage Account Info</a></h3>
            <ul>
                <li>Name: <?= $_SESSION['userFirstName'] . " " . $_SESSION['userLastName'] ?></li>
                <li>Email: <?= $_SESSION['userEmail'] ?></li>
                <li>Phone: <?= $_SESSION['userPhone'] ?></li>
            </ul>
        </div>
        <div class="tripDetails">
            <h3>Your Flights</h3>
            <?php if (empty($flights)){
                echo '<h4> You have no flights booked. </h4>';
            } else{ ?>
            <div class="tableWrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Depature Airport</th>
                            <th>Arrival Airport</th>
                            <th>Depature Date</th>
                            <th>Arrival Date</th>
                            <th>Meal</th>
                            <th>Seat</th>
                            <th>Class</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($flights)){ 
                    foreach($flights as $f) { ?>
                        <tr>
                            <td><?=  $f->departureairport; ?>
                                <br>
                                <form action='' method='POST'>
                                    <input type='hidden' name='flightId' value='<?= $f->flightid?>'/>
                                    <button type='submit' class='linkBtn' name='flightSubmit'>View Details</button>
                                </form>
                            </td>
                            <td><?=  $f->arrivalairport; ?></td>
                            <td><?=  $f->departuredate; ?></td>
                            <td><?=  $f->arrivaldate; ?></td>
                            <td>
                                <?php   
                                if ($f->departuredate < $date){
                                    echo "<p class='unavailable'>Unavailable</p>";
                                } 
                                else{
                                    if(empty($f->meal)){
                                        echo "<form action='./mealSelection.php' method='POST'>
                                            <input type='hidden' name='flightBookingID' value='$f->id' />
                                            <input class='addBtn' type='submit' name='sendFlightBookingID' value='Add Meal' />
                                        </form>";  
                                    }
                                    else{
                                        echo $f->meal;
                                        echo "<form action='./mealSelection.php'' method='POST'>
                                                <input type='hidden' name='postFlightBookingID' value='$f->id'/>
                                                <button type='submit' class='linkBtn' name='flightSubmit'>Update</button>
                                            </form>";
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php   
                                    if ($f->departuredate < $date){
                                        echo "<p class='unavailable'>Unavailable</p>";
                                    } 
                                    else{
                                        if(empty($f->seat_id)){
                                            echo "<form action='./seatSelection.php' method='POST'>
                                            <input type='hidden' name='postFlightBookingID' value='$f->id' />
                                            <input class='addBtn' type='submit' name='sendFlightBookingID' value='Select Seat' />
                                        </form>";  
                                        }
                                        else{
                                            echo $f->seat_id;
                                            echo "<form action='./seatSelection.php'' method='POST'>
                                                    <input type='hidden' name='postFlightBookingID' value='$f->id'/>
                                                    <button type='submit' class='linkBtn' name='flightSubmit'>Update</button>
                                                </form>";
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                <?php   
                                if (empty($f->class)){
                                    if ($f->departuredate < $date){
                                        echo "<p class='unavailable'>Unavailable</p>";
                                    } else{
                                    echo "<form action='./classSelection.php' method='POST'>
                                            <input type='hidden' name='postFlightBookingID' value='" . $f->id . "' />
                                            <input class='addBtn' type='submit' name='sendFlightBookingID' value='Select Class' />
                                        </form>";
                                    }
                                } else{
                                    echo $f->class;
                                    echo "<form action='./classSelection.php'' method='POST'>
                                    <input type='hidden' name='postFlightBookingID' value='$f->id'/>
                                    <button type='submit' class='linkBtn' name='flightSubmit'>Update</button>
                                        </form>";
                                }
                                ?>
                            </td>
                            <td>
                            <?php   
                                if ($f->departuredate < $date){
                                    echo "<p class='unavailable'>Completed</p>";
                                } else{
                                echo "<form action='./deleteFlightBooking.php' method='POST'>
                                            <input type='hidden' name='flightBookingId' value='$f->id'/>
                                            <input type='submit' class='deleteBtn' name='cancelFlightBooking' value='Cancel'/>
                                    </form>";
                                }
                                ?>
                            </td>
                    <?php }}}
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tripDetails">
            <h3>Your Accomodations</h3>
            <?php if (empty($hotels)){
                echo '<h4> You have no accomodations booked. </h4>';
            } else{ ?>
            <div class="tableWrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Hotel Name</th>
                            <th>Address</th>
                            <th>Check-In Date</th>
                            <th>Check-Out Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($hotels)){ 
                    foreach($hotels as $h) { ?>
                        <tr>
                            <td><?=  $h->hotelname; ?></td>
                            <td><?=  $h->hoteladdress; ?><br><?=  $h->city; ?>, <?=  $h->country; ?></td>
                            <td><?=  $h->checkintime; ?></td>
                            <td><?=  $h->checkouttime; ?></td>
                            <td>
                            <?php   
                                if ($h->checkintime < $date){
                                    echo "<p class='unavailable'>Completed</p>";
                                } else{
                                echo "<form action='./deleteHotelBooking.php' method='POST'>
                                            <input type='hidden' name='hotelBookingId' value='$h->id'/>
                                            <input type='submit' class='deleteBtn' name='cancelHotelBooking' value='Cancel'/>
                                    </form>";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php }}}
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tripDetails">
            <h3>Your Vehicle Rentals</h3>
            <?php if (empty($vehicles)){
                echo '<h4> You have no vehicle rentals. </h4>';
            } else{ ?>
            <div class="tableWrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Make/Model</th>
                            <th>Price (per Day)</th>
                            <th>Rental Company</th>
                            <th>Pick-Up Date</th>
                            <th>Return Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($vehicles)){ 
                    foreach($vehicles as $v) { ?>
                        <tr>
                            <td><?=  $v->vehiclemake; ?> <?=  $v->vehiclemodel; ?><br><a class="linkBtn" target="_blank" href="./images/vehicles/<?= $v->vehicleimage?>">View Image</a></td>
                            <td>$<?=  $v->vehicleprice; ?></td>
                            <td><?=  $v->rentalcompanyname; ?><br>
                                <?=  $v->rentalcompanyaddress; ?></td>
                            <td><?=  $v->pickupdate; ?></td>
                            <td><?=  $v->returndate; ?></td>
                            <td>
                            <?php   
                                if ($v->pickupdate < $date){
                                    echo "<p class='unavailable'>Completed</p>";
                                } else{
                                echo "<form action='./deleteVehicleRental.php' method='POST'>
                                            <input type='hidden' name='vehicleRentalId' value='$v->id'/>
                                            <input type='submit' class='deleteBtn' name='cancelVehicleRental' value='Cancel'/>
                                    </form>";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php }}}
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php
require_once 'views/footer.php';
?>
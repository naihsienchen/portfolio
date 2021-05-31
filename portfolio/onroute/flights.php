<?php
    use ONROUTE\models\{Database,Flight};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    $css = array('styles/flights.css'); //Add unqiue css files here
    require_once 'views/header.php';

    //Initialize variables for toggling display information
    $errMsg = "";
    $userHide = "";
    $userDisplay = "style='display:none;'";
    $hide = "style='display:none;'";

    //Checks if user is logged in, displays respective interface
    if (isset($_SESSION['userID'])) {
        $userHide = "style='display:none;'";
        $userDisplay = "style='display:block;'";
    }

    //Gets current date to compare to flight dates, to avoid booking capabilities for past flights
    $pastDate = "";
    $dateNow = new DateTime("NOW", new DateTimeZone('America/Toronto'));
    $date = date_format($dateNow, 'Y-m-d,  H:i:s');

    //instantiate database connection
    $db = Database::getDb();

    //Checks when form is submitted
    if(isset($_POST['searchFlightDB'])){
        //Checks for empty field input
        if(empty($_POST['searchInput'])){
            $errMsg = 'Please enter an airport code, airline name, location, etc.';
        }

        else{
            //Gets the search input submitted and store as variable
            $searchInput = $_POST['searchInput'];
    
            //When flight search query is submitted, instantiate db connection, utilize searchInput
            $flightController = new Flight($db);
    
            //send flight search input to controller 
            $result = $flightController->searchFlight($searchInput);
    
            //Checks results of search
            if($result == false){
                $errMsg = "No flights found with those search results.";
            } 
            else{
                $hide = "style='display:table;'";
                $_SESSION['flightInfo'] = $result; //Store the $result as a session var
            }
        }
    }

    //flight navigation 
    $flightNav = array('Track Flight' => "flightNumberSearch.php", 'In Flight Meal' => "mealSelection.php", 'Seat Selection' => "seatSelection.php" );

?>
<main>
    <!-- Daniel Guinto's Section-->
    <div class="searchDiv">
        <form method="POST" action="">
            <div class="searchDiv__field">
                <label for="searchInput">Search for a flight: </label>
                <div class="searchDiv__field_bar">
                    <input type="text" name="searchInput" id="searchInput" placeholder="Search Flights..." results="0"/>
                    <button type="submit" class="searchBtn" name="searchFlightDB"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="errMsg"><?= $errMsg?></div>
    <div class="tableWrapper">
        <table <?= $hide ?> >
        <h3 <?= $hide ?>>Search Results</h3>
            <thead>
                <tr>
                    <th>Depature Airport</th>
                    <th>Arrival Airport</th>
                    <th>Depature Date</th>
                    <th>Depature Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if (isset($result)){
                    foreach($result as $flight) { 
            ?>
                <tr>
                    <td><?=  $flight->departureairport; ?></td>
                    <td><?=  $flight->arrivalairport; ?></td>
                    <td><?=  $flight->departuredate; ?></td>
                    <td><?=  $flight->arrivaldate; ?></td>
                    <td>
                        <form action="
                        <?php if (isset($_SESSION['userID'])){ echo "./flightBooking.php"; } else {echo "./login.php";} ?>" method="POST">
                            <input type="hidden" name="flightId" value="<?= $flight->flightid; ?>"/>
                            <button type="submit" class="bookBtn" name="bookFlight" <?php if ($flight->departuredate < $date){echo "style='display:none'";} else{echo "style='display:block'";} ?>>Book</button>
                        </form>
                        <p class="hiddenMsg" <?php if ($flight->departuredate < $date){echo "style='display:block'";} else{echo "style='display:none'";} ?> >Book Unavailable</p>
                    </td>
            <?php }}
            ?>
            </tbody>
        </table>
    </div>
    <div class="otherOptions" <?= $userHide ?>>
        <h2>See What We Have To Offer</h2>
        <div class="otherOptions__opt">
            <a href="login.php"><img src="images/flights/difa-naufal-airplane-unsplash.jpg" alt="Image of Plane flying"/></a>
        </div>
        <div class="otherOptions__opt">
            <a href="login.php"><img src="images/flights/meal5.jpeg" alt="Image of on-flight meal from Air France" /></a>
        </div>
        <div class="otherOptions__opt">
            <a href="login.php"><img src="images/flights/jorge-rosal-planeseat-unsplash.jpg" alt="Image of man taking picture from plane window"/></a>
        </div> 
    </div>
    <p <?= $userHide ?> class="otherOptions__msg"><a href="login.php">Log in</a> to view these options for your flights!</p>

    <div class="otherOptions" <?= $userDisplay ?>>
        <h2>Your Flights</h2>
        <?php 
        $flightController = new Flight($db);
        $flights = $flightController->getFlightBookingByUser($_SESSION['userID']);

        if (empty($flights)){
                echo '<h4> You have no flights booked. </h4>';
            } 
        else{ ?>
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
                                            <input type='hidden' name='postFlightBookingID' value='$f->id' />
                                            <input class='addBtn' type='submit' name='sendFlightBookingID' value='Select Class' />
                                        </form>";
                                    }
                                } else{
                                    echo $f->class;
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
                    <?php }
                    }
                }?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="banner">
        <h2><a href="flightNumberSearch.php">Track a Flight</a></h2>
    </div>
</main>

<?php
require_once 'views/footer.php';
?>
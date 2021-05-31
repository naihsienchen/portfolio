
<!-- A user can see the seats available and select the seat they want -->
<!-- FOR future, database would be better designed without the flightsxflightseats bridging table. instead use flightbookings to bridge flights and flight seats. Get all the seats for a plane in a list of onbjects. Then check flightbookings join seats on seat id where flightId is the current flight id. If this entry exists, the seat is taken. You could also make a function in sql to show the view -->
<?php 
    use OnRoute\models\{Database,Flight, Meal, Plane};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    require_once 'models/flight.php';
    require_once 'models/plane.php';
    require_once 'models/meal.php';
    require_once 'models/database.php';

    $css = array("styles/seatSelection.css");
    require_once 'views/header.php';



    //IF USER IS NOT LOGGED IN SEND THEM BACK TO FLIGHTS PAGE 
    if(/* !isset($_SESSION['userID']) || */ !isset($_POST['postFlightBookingID'])|| $_POST['postFlightBookingID'] === ""){
    header('location:flights.php');
    }

    $hide1 = "style = 'display:none'";
    $hide2 = "";

    /*IF USER HAS SUBMITTED A SEAT ON THIS PAGE, DISPLAY CONFIRMATION AND ADD TO DB */
    if(isset($_POST['seatSubmit'])){
        /* IF user did not select a seat before submitting show error and reload seat selection view*/
        if(!isset($_POST['seatSelected'])){
            $errMsg = "Please make a selection before submitting!";
        }

        else{
             //Assign post data to vars
             $seatId = $_POST['seatSelected'];
             $flightBookingId = $_POST['postFlightBookingID'];
             $flightId = $_POST['flightId'];
             $currentSeatId = $_POST['currentSeat'];
            //connect to database
            $db = Database::getDB();
            
            /*Update the flight booking with the new seat*/
            $flightController = new Flight($db);
            $flightController->updateSeatForFlightBooking($flightBookingId, $seatId);

            //Update the status of the user's currentSeat to "Available" if they have a current selection
            if($currentSeatId != null){
                $flightController->unbookSeatForFlight($flightId, $currentSeatId);
            }
            /*Change the status of the user's new seat to "Unavaliable" for this flight*/
            $flightController->bookSeatForFlight($flightId, $seatId);

            //Change the display of the page to show confirmation
            $hide2 = "style = 'display:none'";
            $hide1 = "";
        }
    }

    /* When user loads page (before selecting seat) */
    /* Step 1 -- get flight details for the flight booking id and extract the flight Id */

    $flightBookingId = $_POST['postFlightBookingID'];
    
    /*  Connect to database and use*/
    $db = Database::getDB();
    $flightController = new Flight($db);

    //if bookingId is currently associated with a seatId, store it as "currentSeatId"
    $currentSeatId = $flightController->getFlightBookingsById($flightBookingId)->seat_id;
    if($currentSeatId != null){
        $userMsg = "You previously booked seat ".$currentSeatId.". If you would like to update your seat, please make a selection below.";
    }
    /* getFlightDetailsByBookingId($flightBookingId)*/
    $flightDetails = $flightController->getFlightDetailsByBookingId($flightBookingId);
    /* Extract the flight id  */
   /*  print_r ($flightDetails); */
    $flightId = $flightDetails->flightId;
    $planeId = $flightDetails->plane_id;
    

    /* Step 2 -- For the given flightId, retrieve the seats for that flight, including availability and seat_id using the getSeatsForFlight($fligt)*/
    $seats = $flightController->getSeatsForFlight($flightId);
   /*  print_r($seats);
    echo "</br></br>"; */
    
    /* Step 3 -- For the flight, get isles and columns, using the getPlaneDetailsById($planeId) method  */
    $planeController = new Plane($db);
    $planeDetails = $planeController->getPlaneDetailsById($planeId);
  /*   print_r($planeDetails); */

    /* Step 4 - Populate the seat selection table */
    /* Calculate the #Columns/(#isles + 1)- this is the number of seats clustered side-by-side, separated by the isles  */
    $numColumns = $planeDetails->columns;
    $numIsles = $planeDetails->isles;
    $seatsAbreast = $numColumns/($numIsles+1);
    $numRows = ceil(count($seats)/$numColumns);
    /* echo "THE NUMBER OF ROWS WILL BE: ". $numRows; */

    /* Number of header column spaces in table */
    $numTableColumns = $numColumns + $numIsles;
   /*  echo  "</br></br>".$seatsAbreast; */

    /* WRITE THE SEATS TABLE HEADER */
    $alphabet = range('A', 'Z'); /* Handy --> https://stackoverflow.com/questions/4084103/add-divide-numbers-in-php */
    $tableHeader = "<tr>";
    for($i = 1; $i <= $numTableColumns; $i++){
        /* If i is a multiple of the seatsAbreast+1, make this an empty row to indicate an isle */
        if($i % ($seatsAbreast+1) == 0){
            $tableHeader .= "<td class='isle' rowspan=".($numRows + 1).">ISLE</td>";
        }
        /* otherwise, assign the corresponding letter of the alphabet of "i" to the table head column */
        else{
            $tableHeader .= "<td class='columnHeader'>".$alphabet[$i-1]."</td>";
        }
    }

    $tableHeader .= "</tr>";

   /*  echo "</br></br> TABLE HEADER: ".$tableHeader; */

    /* WRITE THE TABLE BODY */
    $tableBody = "<tr>";
    for($i=1; $i <= count($seats); $i++){
        /* If the current object has an index within the $seats array that is a  multiple of the number of columns minus 1, create new row. */
        if($i % ($numColumns) == 0){
            if($seats[$i-1]->bookingstatus == "Available"){
                $tableBody .= "<td class = 'available'><input class = 'radioButton' type='radio' name='seatSelected' value='".$seats[$i-1]->seat_id."'/>".$seats[$i-1]->seat_id."</td></tr><tr>";
            }
            elseif($seats[$i-1]->seat_id == $currentSeatId){
                $tableBody .= "<td class = 'currentSeat'>".$seats[$i-1]->seat_id."</td></tr><tr>";
            }

            else{
                $tableBody .= "<td class = 'unavailable'>".$seats[$i-1]->seat_id."</td></tr><tr>";
            }
        }
        /* Otherwise, add the seat as usual */
        else{
            if($seats[$i-1]->bookingstatus == "Available"){
                $tableBody .= "<td class = 'available'><input class = 'radioButton' type='radio' name='seatSelected' value='".$seats[$i-1]->seat_id."'/>".$seats[$i-1]->seat_id."</td>";
            }
            elseif($seats[$i-1]->seat_id == $currentSeatId){
                $tableBody .= "<td class = 'currentSeat'>".$seats[$i-1]->seat_id."</td>";
            }
            else{
                $tableBody .= "<td class = 'unavailable'>".$seats[$i-1]->seat_id."</td>";
            }
        }
    }

    $tableBody .= "</tr>";

    /* Step 5 - when submitted, update the seat as unavailable, add it to the seat_id on the flightBookingID. If the user had a previous seat selected, change that seat to available */
    if(isset($_POST['seatSubmit'])){
        $seatSelected = $_POST['seatSubmit'];
        /* Add to flightBooking using updateSeatForFlightBooking*/
    }
?>
<main>
    <!-- Flight track form appears on page load -->
    <div class = "seatSelection" <?=$hide2?>>
        <h2><?=isset($userMsg)? $userMsg : "Please Select a Seat Below"; ?></h2>
        <form action="" method="POST" name = "seatSelection__form">
            <input type="hidden" name="postFlightBookingID" value="<?=$flightBookingId;?>"/>
            <input type="hidden" name="flightId" value="<?=$flightId?>"/>
            <input type="hidden" name="currentSeat" value="<?=$currentSeatId?>"/>
            
            <div class = "seatSelection_flex">
                <p><?=isset($errMsg)? $errMsg : ""?></p>
                <table>
                    <?=$tableHeader?>
                    <?=$tableBody?>
                </table>
                <div>
                    <button class="seatSelection_btn" type="submit" name="seatSubmit" value="1">Select</button>
                </div>
            </div>
        </form>
    </div>
    <!-- On form submission, mealConfirmation displays and mealSelection is set to display:none -->
    <div class = "seatSelection_flex" <?=$hide1?>>
        <h2>Your seat for this flight is <?=$seatId?>. Thank you for your selection!</h2>
    </div>
</main>
<script src="library/seatSelection.js"></script>
<?php 
    require_once 'views/footer.php';
?>

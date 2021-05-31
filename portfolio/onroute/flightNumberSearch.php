<!-- Once a user has booked their flight, they can enter their flight number to see the flight details this does not require a login. It is a quicker way for customers to view their flight details, rather than logging in and checking their bookings-->
<?php
    use OnRoute\models\{Database,Flight};
    require_once 'vendor/autoload.php';
    require_once 'library/functions.php';
    require_once 'models/flight.php';
    require_once 'models/database.php';
    $css = array("styles/flightTracking.css");
    require_once 'views/header.php';

    //WHEN FORM IS SUBMITTED
    if(isset($_POST['flightSubmit'])){
        /* header('location: flightInfo.php'); */
        //Was there a flight number submitted?
        if($_POST['flightId'] == ""){
            $errMsg = 'Please enter a flight number';
        }

        else{
            //get the flight id submitted and store as variable
            $flightId = $_POST['flightId'];

            //instantiate database connection
            $db = Database::getDb();
    
            //When flight number submitted, instantiate db connection, utilize getFlightById
            $flightController = new Flight($db);
    
            //send flightId to controller 
            $flight = $flightController->getFlightById($flightId);
            var_dump($flight);

            if($flight == false){
                $errMsg = "We couldn't find that flight. Did you double check your flight number?";
            } 

            else{
                /* Get airline object for this flight */
                $airlineId = $flight->airline_id;
                $airline = $flightController->getAirLineById($airlineId);
                var_dump($airline);
                $airlineLogoLink = $airline->imagepath;

                //store the $response as a session var
                $_SESSION['flightInfo'] = $flight;
                $_SESSION['airlineLogoLink'] = $airlineLogoLink;
                //redirect user to the flightInfo pages
                header ('Location:flightInfo.php');   
            }
        }
    }


?>
<!-- <script src='library/flightTracking.js'></script>
 --><main>
    <div class = "flightTrack">
        <h2>Track Your Flight</h2>
        <p>Here you can track the latest information on your flight. Just enter your flight number below.</p>
        <form class ="flightTrack__form" action="" method="POST" name = "flightTrack__form">
            <div>
                <label for="flightId">Flight ID Number</label>
                <input type="text" id="flightId" name="flightId"/>
                </br></br>
                <span><?= isset($errMsg)? " " . $errMsg : '';?></span>
            </div>
            <button type="submit" name="flightSubmit" value="submitted">GO!</button>
        </form>
    </div>
</main>
<?php 
    require_once 'views/footer.php';
?>

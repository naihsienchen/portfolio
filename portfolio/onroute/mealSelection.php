
<!-- A user can see the meals available and select the meal they want-->
<?php 
     use OnRoute\models\{Database,Flight, Meal};
     require_once 'vendor/autoload.php';
     require_once 'library/functions.php';
     require_once 'models/flight.php';
     require_once 'models/meal.php';
     require_once 'models/database.php';
     
    $css = array("styles/mealSelection.css");
    require_once 'views/header.php';

    

    //IF USER IS NOT LOGGED IN SEND THEM BACK TO FLIGHTS PAGE 
    if(/* !isset($_SESSION['userID']) || */ !isset($_POST['postFlightBookingID'])){
        header('location:flights.php');
    }
    echo $_POST['postFlightBookingID'];
    $hide1 = "style = 'display:none'";
    $hide2 = "";
    /* IF USER HAS CLICKED SUBMIT BUTTON FROM THIS PAGE */
    if(isset($_POST['mealSubmit'])){
        if(!isset($_POST['mealId'])){
            $errMsg = "Please make a selection before submitting!";
        }

        else{
            //connect to database
            $db = Database::getDB();

            //Assign post data to vars
            $mealId = $_POST['mealId'];
            $flightBookingId = $_POST['postFlightBookingID'];

            /*Get the meal name corresponding to that ID*/
            $meal = new Meal($db);
            $mealName = $meal->getMealById($mealId)->meal;

            /*Update the database with new meal*/
            $meal->addMealForFlight($flightBookingId, $mealId);

            //Change the display of the page to show confirmation
            $hide2 = "style = 'display:none'";
            $hide1 = "";
        }
    }

    //Otherwise get the database entry for the flightBookingId provided
    $flightBookingId = $_POST['postFlightBookingID'];
    $db = Database::getDB();
    $flightController = new Flight($db);
    $flightBooking = $flightController->getFlightBookingsById($flightBookingId);

    /* Get the meals from the database */
    $meals = new Meal($db);
    $mealList = $meals->getMeals();
    $selectionRows = "";
    foreach($mealList as $meal){
        $thisRow = "<div class = 'selection_row unselected'>
                        <p class = mealDescription>
                            <strong>$meal->meal</strong></br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Vel risus commodo viverra maecenas accumsan lacus vel. Eget mi proin sed libero enim sed.
                        </p>
                        <div class = 'mealImage' style = 'background-image: url(images/flights/meal".$meal->id.".jpg)'>
                            <input class = radioButton type=radio value=$meal->id name='mealId'/>
                        </div>
                    </div>";
        $selectionRows .= $thisRow;
    } 
    /* IF MEAL HAS BEEN PREVIOUSLY SET */
    if(isset($flightBooking->meal)) {
        $userMsg = 'You previously selected '.$flightBooking->meal. ". Select another option below to update your choice.";
    }
    //IF NOT SET, DISPLAY AS NORMAL - MAKE CALL TO DATABASE TO STORE NEW MEAL SELECTION
?>
<main>
    <h1>Meal Selection</h1>
    <!-- Flight track form appears on page load -->
    <div <?=$hide2?>>
        <form action="" method="POST" name="mealSelection_form">
            <input type = hidden name = "postFlightBookingID" value = '<?=$flightBookingId?>'/>
            <div class = "selections">
                <h2><?= isset($userMsg)? $userMsg : "Please Make a Meal Choice From the Options Below";?></h2>
                <?= isset($errMsg)? $errMsg:"";?>
                <!-- Output the html divs from the forloop containing meal info from database -->
                <?= ($selectionRows != "")? $selectionRows:"Sorry, there are no meal options available for this flight.";?>
                <div class = "button_row">
                    <button class = "selection_btn" type="submit" name="mealSubmit" value="submit">Select</button>
                </div>
            </div>
        </form>
    </div>
    <!-- On form submission, mealConfirmation displays and mealSelection is set to display:none -->
    <!-- intitially hidden page section -->
    <div class="mealSelected" <?=$hide1?>>
        <h2>You will be served <?=isset($mealName)? $mealName : "";?> on your flight. Thank you for your selection!</h2>
         <!-- Import meal image -->
        <img alt="photo of your meal" src="images/flights/meal<?=isset($mealId)? $mealId : "";?>.jpg"/>
        </br>
        <a class = "secondaryLink" href="flights.php">Back To Flights</a>
    </div>
</main>
<script type="text/javascript" src="library/mealSelection.js"></script>
<?php 
    require_once 'views/footer.php';
?>

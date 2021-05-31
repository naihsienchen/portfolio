<?php
    $css = array('styles/flights.css');
    require_once 'library/functions.php';
    require_once './views/header.php';

    if(!isset($_POST['postFlightBookingID'])){
        Header('Location: flights.php');
    }

    if (isset($_SESSION['userID'])) {
        //Placeholder for now
       
    } else {
        //Redirects to flights page if user is not logged in
        Header('Location: flights.php');
    }

    //add the posted flightbookingid to a var and send as hidden input
    $postFlightBookingID = $_POST['postFlightBookingID']

    
?>

<main>
    <div class="otherOptions">
        <h2>Your flight details</h2>

        <div class="otherOptions__opt">
            <a href="flightNumberSearch.php"><img src="images/flights/difa-naufal-airplane-unsplash.jpg" alt="Image of Plane flying"/></a>
        </div>
        <form class="otherOptions__opt" action="mealSelection.php" method="POST">
            <input type="hidden" name ="postFlightBookingID" value ="<?=$postFlightBookingID?>"/>
            <button type="submit"><img src="images/flights/meal5.jpeg" alt="Image of on-flight meal from Air France" /></button>
        </form>
        <form class="otherOptions__opt" action="seatSelection.php" method="POST">
            <input type="hidden" name ="postFlightBookingID" value ="1"/>
            <button type="submit"><img src="images/flights/jorge-rosal-planeseat-unsplash.jpg" alt="Image of man taking picture from plane window" /></button>
        </form>
    </div>
</main>


<?php 
    require_once './views/footer.php';
?>
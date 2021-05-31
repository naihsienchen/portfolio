<?php
    require_once 'library/functions.php';
    $css = array("styles/flightTracking.css");
    require_once 'views/header.php';
    //access session var 
    $flightInfo = $_SESSION['flightInfo'];
    $airlineLogoLink = $_SESSION['airlineLogoLink'];
?>
<main>
    <div class = "flightInfo">
        <h2>Flight <?php echo $flightInfo->flightid ?></h2>
         <!-- Import airline image-->
        

        <div class = "flightInfoRow">
            <ul class = "flightInfoRow_item">
                <h3>Departure</h3>
                <li>Airport: <?php echo $flightInfo->departureairport?></li>
                <li>Terminal: <?php echo $flightInfo->departureterminal?></li>
                <li>Date: <?php echo date('Y-m-d', strtotime($flightInfo->departuredate))?></li>
                <li>Time: <?php echo date('H:i', strtotime($flightInfo->departuredate))?></li>
            </ul>
            <div class = "flightInfoRow_item">
                <img src = <?php echo $airlineLogoLink?> alt = "airlineLogo"></img>
                <i class="fas fa-plane fa-3x"></i>
            </div>
            <ul class = "flightInfoRow_item">
                <h3>Arrival</h3>
                <li>Airport: <?php echo $flightInfo->arrivalairport?></li>
                <li>Terminal: <?php echo $flightInfo->arrivalterminal?></li>
                <li>Date: <?php echo date('Y-m-d', strtotime($flightInfo->arrivaldate))?></li>
                <li>Time: <?php echo date('H:i', strtotime($flightInfo->arrivaldate))?></li>
            </ul>
        </div>
    </div>
</main>
<?php 
    require_once 'views/footer.php';
?>
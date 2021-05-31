<?php
    //=====hotel feature requirements=====//
    use OnRoute\models\Database;
    use OnRoute\models\Hotel;
    
    require_once './vendor/autoload.php';//doesen't work
    require_once 'library/functions.php';
    require_once './models/Hotel.php';
    require_once './models/Database.php';//if autoload is working, we don't seem to need this

    //Add unqiue css files here
    $css = array('styles/hotelDetails.css');
    require_once('views/header.php');
    
    //test database conneciton
    $dbcon = Database::getDB();
    
    //get method
    $h = new Hotel();   
    //=====hotel feature requirements=====//

    $city = ""; 
    $guestnumber = "";   
    $checkin = "";
    $checkout = "";
    $hotel_id = "";
    $hotelroom_id = "";
    if(isset($_POST['tripFrom__input_btn'])){
        $city = $_POST['city'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $guestnumber = $_POST['guestnumber'];
    
        $c = $h->getHotelsandRoomsByCityandGuest($city, $guestnumber, $dbcon);
?>
<main>
    <div class="searchResult">
    <h2>Your Destination: <?= $city ?></h2>
<?php
    foreach ($c as $hotel){
        $hotelname = $hotel['hotelname'];//in arrays we retrieve properties with [] not =>
?>    
    <h3 id="hotelname"><?= $hotelname ?></h3>
    <div class="searchResult__container">
        <div class="searchResult__image">
            <img src="./images/accommodations/a<?=$hotel['hotel_id'] ?>.jpg" width="500px"/>
        </div>
        <div class="searchResult__desc">
            <p class="searchResult__desc_guestNumber">Guest number: <?= $hotel['guestnumber']?></p>
            <p class="searchResult__desc_roomDesc">Description: <?= $hotel['description']?></p>
        </div>
        <div class="searchResult__form">
            <form id="searchResult__form_hiddenform" method="post" action="hotelBooking.php">
                <input type="hidden" name="city" value="<?= $city ?>" />
                <input type="hidden" name="hoteladdress" value="<?= $hotel['hoteladdress'] ?>" />
                <input type="hidden" name="country" value="<?= $hotel['country'] ?>" />
                <input type="hidden" name="hotel_id" value="<?= $hotel['hotel_id'] ?>" />
                <input type="hidden" name="hotelname" value="<?= $hotelname ?>" />
                <input type="hidden" name="checkin" value="<?= $checkin ?>" />
                <input type="hidden" name="checkout" value="<?= $checkout ?>" />
                <input type="hidden" name="hotelroom_id" value="<?= $hotel['id'] ?>" />
                <input type="hidden" name="guestnumber" value="<?= $guestnumber ?>" />
                <input type="submit" name="reserveNow" value="Reserve Now" />
            </form>
        </div>
    </div>
    </div>
<?php
        }
    }
    require_once 'views/footer.php';
?>
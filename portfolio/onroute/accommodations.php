<?php
    //=====hotel feature requirements=====//
    use OnRoute\models\Database;
    use OnRoute\models\Hotel;
    
    require_once './vendor/autoload.php';//doesen't work: captitalization in composer
    require_once 'library/functions.php';
    require_once './models/Hotel.php';
    require_once './models/Database.php';//if autoload is working, we don't seem to need this

    //Add unqiue css files here
    $css = array('styles/accommodations.css');
    require_once('views/header.php');
    
    //test database conneciton
    $dbcon = Database::getDB();
    
    //get method
    $h = new Hotel();   
    //=====hotel feature requirements=====//
?>

<!--copied from content.php and modified-->
<!-- Content -->
<main>
    <!-- <div class="background"></div> -->
    <h2>Accommodations</h2>
    <!--FORM TO BE FIXED IN ORDER TO FUNCTION (names, paths, etc.)-->
    <form method="post" action="hotelDetails.php">
        <div class="initialForm">
            <h2>Your Dream Vacation Awaits</h2>
        </div>
        <div class="tripFrom">
            <div class="tripFrom__input">
                <label>Going To</label>
                <input type=text name="city" />
            </div>
                <div class="tripFrom__input">
                <label>Check In</label>
            <input type=date name="checkin"/>
            </div>
            <div class="tripFrom__input">
                <label>Check Out</label>
                <input type=date name="checkout"/>
            </div>
            <div class="tripFrom__input">
                <label>Number of Guests</label>
                <input type=text name="guestnumber" />
            </div>
            <div class="tripFrom__input">
                <input class="tripFrom__input_btn" type="submit" name="tripFrom__input_btn" value="Search" />
            </div>
        </div>
    </form>
    <?php
        $city = "";
        $checkin = "";
        $checkout = "";
        $guestnumber = "";
        if(isset($_POST['tripFrom__input_btn'])){
            $city = $_POST['city'];
            $checkin = $_POST['checkin'];
            $checkout = $_POST['checkout'];
            $guestnumber = $_POST['guestnumber'];
        }        
    ?>
    <div class="searchResult">
        <h2><?= $city ?></h2>
    <?php
        $c = $h->getHotelsandRoomsByCityandGuest($city, $guestnumber, $dbcon);
        foreach ($c as $hotel){
            $hotelname = $hotel['hotelname'];//in arrays we retrieve properties with [] not =>
    ?>    
        <h3><?= $hotelname ?></h3>
        <div class="searchResult__container">
            <div class="searchResult__image">
                <img src="./images/accommodations/a<?= $hotel['hotel_id'] ?>.jpg" width="200px"/>
            </div>
            <div class="searchResult__desc">
                <p class="searchResult__desc_guestNumber">Guest number: <?= $hotel['guestnumber']?></p>
                <p class="searchResult__desc_roomDesc">Description: <?= $hotel['description']?></p>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="deals">
        <h2>Popular Choices</h2>
        <div class="deals__popular">
            <div class="deals__popular_opt">
                <p>
                <a href="images/accommodations/a1.jpg"><img src="images/accommodations/a1.jpg" alt="" width="" /></a>
                </p>
            </div>
            <div class="deals__popular_opt">
                <p>
                <a href="images/accommodations/a2.jpg"><img src="images/accommodations/a2.jpg" alt="" width="" /></a>
                </p>
            </div>
            <div class="deals__popular_opt">
                <p>
                <a href="images/accommodations/a5.jpg"><img src="images/accommodations/a5.jpg" alt="" width="" /></a>
                </p>
            </div>
            <div class="deals__popular_opt">
                <p>
                <a href="images/accommodations/a6.jpg"><img src="images/accommodations/a6.jpg" alt="" width="" /></a>
                </p>
            </div>
        </div>
        <h2>Lowest Prices</h2>
        <div class="deals__budget">
            <div class="deals__budget_opt">
                <p><a href="images/accommodations/a3.jpg"><img src="images/accommodations/a3.jpg" alt="" width="" /></a></p>
            </div>
            <div class="deals__budget_opt">
                <p><a href="images/accommodations/a4.jpg"><img src="images/accommodations/a4.jpg" alt="" width="" /></a></p>
            </div>
            <div class="deals__budget_opt">
                <p><a href="images/accommodations/a8.jpg"><img src="images/accommodations/a8.jpg" alt="" width="" /></a></p>
            </div>
            <div class="deals__budget_opt">
                <p><a href="images/accommodations/a13.jpg"><img src="images/accommodations/a13.jpg" alt="" width="" /></a></p>
            </div>
        </div>
        </div>
    </div>
</main>
<?php
    require_once 'views/footer.php';
?>
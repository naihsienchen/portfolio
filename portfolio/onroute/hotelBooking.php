<?php
//=====hotel feature requirements=====//
use OnRoute\models\Database;
use OnRoute\models\Hotel;

require_once './vendor/autoload.php';//doesen't work
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

$city = ""; 
$checkin = "";
$checkout = "";
$hotel_id = "";
$hotelroom_id = "";
if(isset($_POST['reserveNow'])){
        $city = $_POST['city'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $hotel_id = $_POST['hotel_id'];
        $hotelroom_id= $_POST['hotelroom_id'];
        $hotelname = $_POST['hotelname'];
        $guestnumber = $_POST['guestnumber'];
        $hoteladdress = $_POST['hoteladdress'];
        $country = $_POST['country'];

        $b = $h->bookHotel($city, $checkin, $checkout, $hotel_id, $hotelroom_id, $dbcon);
    if ($b==true){ 
        echo "
        <div class='hotelBooking__content'>
            <div class='hotelBooking__confirm'>
                <h2>Booking confirmation</h2>";
                echo "<p>Thank you for booking <strong>" . $hotelname . "</strong>. Here's the details of your stay:</p>
                <table class='hotelBooking__confrim_table'>
                    <tr>
                        <th>Hotel name</th>
                        <td>" . $hotelname ."</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>" . $hoteladdress ."</td>
                    </tr>
                    <tr>
                        <th>Check in date</th>
                        <td>" . $checkin ."</td>
                    </tr>
                    <tr>
                        <th>Check out date</th>
                        <td>" . $checkout ."</td>
                    </tr>
                    <tr>
                        <th>Guest number</th>
                        <td>" . $guestnumber ."</td>
                    </tr>
                </table>
                <p>
                Please contact our customer service if any of the information is not correct. Have a nice stay!
                </p>
            </div>
        </div>";
    } else {
         echo "<h3>error booking</h3>";
    }
}
?>

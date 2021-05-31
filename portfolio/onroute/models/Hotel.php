<?php
namespace OnRoute\models;
class Hotel {
    public function getAllHotels($dbcon){
        $sql = "Select * FROM hotels";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();
        $hotels = $pdostm->fetchAll(\PDO::FETCH_OBJ);//WHY FETCH ASSOC, NOT OBJ?
        return $hotels;
    }

    public function getHotelsByCity($city, $dbcon){
        $sql = "Select * FROM hotels WHERE city = :city";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->bindParam(':city', $city);
        $pdostm->execute();
        $hotels = $pdostm->fetchAll(\PDO::FETCH_ASSOC);//WHY FETCH ASSOC, NOT OBJ?
        return $hotels;

        /*
        $pdostm->bindValue(':program', $program, \PDO::PARAM_STR);
        $pdostm->execute();
        $s = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $s;
        */

    }

    public function getHotelById($dbcon){
        $sql = "Select * FROM hotels Where id='2'";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();
        $hotels = $pdostm->fetchAll(\PDO::FETCH_OBJ);//WHY FETCH ASSOC, NOT OBJ?
        return $hotels;
    }

    public function getHotelsandRoomsByCityandGuest($city, $guestnumber, $dbcon){
        $sql = "Select * FROM hotels INNER JOIN hotelrooms on hotels.id = hotelrooms.hotel_id WHERE hotels.city = :city and hotelrooms.guestnumber = :guestnumber";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->bindParam(':city', $city);
        $pdostm->bindParam(':guestnumber', $guestnumber);
        $pdostm->execute();
        $hotels = $pdostm->fetchAll(\PDO::FETCH_ASSOC);//WHY FETCH ASSOC, NOT OBJ?
        return $hotels;
    }

    public function bookHotel($city, $checkin, $checkout, $hotel_id, $hotelroom_id, $dbcon){
        $sql = "INSERT INTO hotelbookings
        VALUES (null, :checkintime, :checkouttime, :hotel_id, :hotelroom_id, 1)";//hard coded user_id for now.
                
        $pdostm = $dbcon->prepare($sql);
        $pdostm->bindParam(':checkintime', $checkin);
        $pdostm->bindParam(':checkouttime', $checkout);
        $pdostm->bindParam(':hotel_id', $hotel_id);
        $pdostm->bindParam(':hotelroom_id', $hotelroom_id);
        $count = $pdostm->execute();
        return $count;

    }
    /* (Note to self: Look into db model)
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }*/
    
    public function getHotelBookingByUser($userId, $dbcon){
        $query = "SELECT * FROM hotels LEFT JOIN hotelbookings ON hotels.id = hotelbookings.hotel_id Where user_id = :userId";

        $request = $dbcon->prepare($query);

        //sanitize
        $request->bindParam(':userId', $userId);
        
        //execute
        $request->execute();

        //fetch result
        $result = $request->fetchAll(\PDO::FETCH_OBJ);

        //return object
        return $result;
    } 

    // public function deleteHotelBooking($hotelBookingId, $dbcon)
    // {
    //     $query = "DELETE FROM hotelbookings WHERE id = :hotelBookingId";

    //     $request = $dbcon->prepare($query);

    //     //sanitize
    //     $request->bindParam(':hotelBookingId', $hotelBookingId);
        
    //     //execute
    //     $request->execute();

    //     //fetch result
    //     $result = $request->fetch(\PDO::FETCH_OBJ);

    //     //return object
    //     return $result;
    // }
}
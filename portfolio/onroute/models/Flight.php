<?php
namespace OnRoute\models;
class Flight{
    //DATABASE CONNECTION

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //DATABASE METHODS

    //get specific flight by flight number
    public function getFlightById($flightId)
    {
        $query = "SELECT *, flights.id AS flightid FROM Flights 
                    LEFT JOIN planes ON flights.plane_id = planes.id
                    LEFT JOIN airlines ON planes.airline_id = airlines.id
                    WHERE flights.id = :flightId";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':flightId', $flightId);

        //execute
        $request->execute();

        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function addFlight($departureairport, $arrivalairport, $departuredate, $arrivaldate, $plane_id)
    {
        $query = "INSERT INTO flights (departureairport, arrivalairport, departuredate, arrivaldate, plane_id) VALUES(:departureairport, :arrivalairport, :departuredate, :arrivaldate, :plane_id)";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':departureairport', $departureairport);
        $request->bindParam(':arrivalairport', $arrivalairport);
        $request->bindParam(':departuredate', $departuredate);
        $request->bindParam(':arrivaldate', $arrivaldate);
        $request->bindParam(':plane_id', $plane_id);

        //execute
        $request->execute();

        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function searchFlight($input){
        $input = "%" . $input . "%";

        $query = "SELECT *, flights.id AS flightid FROM flights 
                    LEFT JOIN planes ON flights.plane_id = planes.id
                    LEFT JOIN airlines ON planes.airline_id = airlines.id
                    WHERE ((departureairport LIKE :input) OR (arrivalairport LIKE :input)OR (departuredate LIKE :input)OR (arrivaldate LIKE :input)OR (airlinename LIKE :input) OR (plane_id LIKE :input))";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':input', $input);
        
        //execute
        $request->execute();

        //fetch result
        $result = $request->fetchAll(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function addFlightBooking($userId, $flightId)
    {

        $query = "INSERT INTO flightbookings (user_id, flight_id) VALUES (:userId, :flightId)";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':userId', $userId);
        $request->bindParam(':flightId', $flightId);
        
        //execute
        $request->execute();

        //fetch result
        $result = $request->fetchAll(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function getFlightBookingByUser($userId)
    {

        $query = "SELECT flights.id AS flightid, seat_id, departureairport, arrivalairport, departuredate, arrivaldate, planes.model, flightbookings.id, flightmeals.meal, flightclasses.class
                    FROM flights 
                    LEFT JOIN planes ON planes.id = flights.plane_id
                    LEFT JOIN flightbookings ON flights.id = flightbookings.flight_id 
                    LEFT JOIN flightmeals ON flightmeals.id = flightbookings.meal_id 
                    LEFT JOIN flightclasses ON flightclasses.id = flightbookings.class_id 
                    WHERE user_id = :userId";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':userId', $userId);
        
        //execute
        $request->execute();

        //fetch result
        $result = $request->fetchAll(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function getFlightDetailsByBookingId($flightBookingId)
    {

        $query = "SELECT flights.id AS flightId, plane_id, flightbookings.id, departureairport, arrivalairport, departuredate, arrivaldate, airlinename
                    FROM flightbookings 
                    LEFT JOIN flights ON flights.id = flightbookings.flight_id
                    LEFT JOIN planes ON flights.plane_id = planes.id
                    LEFT JOIN airlines ON planes.airline_id = airlines.id
                    WHERE flightbookings.id = :flightBookingId";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':flightBookingId', $flightBookingId);
        
        //execute
        $request->execute();

        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function deleteFlightBooking($flightBookingId)
    {
        $query = "DELETE FROM flightbookings WHERE id = :flightBookingId";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':flightBookingId', $flightBookingId);
        
        //execute
        $request->execute();

        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function getFlightBookingsById($flightBookingId){
        $query = "SELECT * FROM flightbookings WHERE flightbookings.id = :flightBookingId";

        $request = $this->db->prepare($query);
        //sanitize
        $request->bindParam(':flightBookingId', $flightBookingId);
        //execute
        $request->execute();
         //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);
         //return object
        return $result;
    }

    public function getSeatsForFlight($flightId){
        $query = "SELECT flightsxflightseats.id, flightsxflightseats.seat_id AS seat_id, bookingstatus FROM flightsxflightseats INNER JOIN flightseats ON flightseats.id = flightsxflightseats.seat_id WHERE flight_id = :flightId";

        $request = $this->db->prepare($query);
         //sanitize
        $request->bindParam(':flightId', $flightId);
        //execute
        $request->execute();
        //fetch result
        $result = $request->fetchAll(\PDO::FETCH_OBJ);
        //return object
        return $result;
    }

    public function updateSeatForFlightBooking($flightBookingId, $seatSelected){
        $query = "UPDATE flightbookings SET seat_id = :seatSelected WHERE flightbookings.id = :flightBookingId";
        
        $request = $this->db->prepare($query);
        //sanitize
        $request->bindParam(':flightBookingId', $flightBookingId);
        $request->bindParam(':seatSelected', $seatSelected);
        //execute
        $request->execute();
        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);
        //return object
        return $result;
    }

    public function bookSeatForFlight($flightId, $seatId){
        $query = "UPDATE flightsxflightseats SET bookingstatus = 'Unvailable' WHERE flightsxflightseats.flight_id = :flightId AND flightsxflightseats.seat_id = :seatId";
    
        $request = $this->db->prepare($query);
        //sanitize
        $request->bindParam(':flightId', $flightId);
        $request->bindParam(':seatId', $seatId);
        //execute
        $request->execute();
        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);
        //return object
        return $result;
    }

    public function unbookSeatForFlight($flightId, $seatId){
        $query = "UPDATE flightsxflightseats SET bookingstatus = 'Available' WHERE flightsxflightseats.flight_id = :flightId AND flightsxflightseats.seat_id = :seatId";
    
        $request = $this->db->prepare($query);
        //sanitize
        $request->bindParam(':flightId', $flightId);
        $request->bindParam(':seatId', $seatId);
        //execute
        $request->execute();
        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);
        //return object
        return $result;
    }

    public function getAirLineById($airlineId){
        $query = "SELECT * FROM airlines WHERE airlines.id = :airlineId";

        $request = $this->db->prepare($query);
        //sanitize
        $request->bindParam(':airlineId', $airlineId);
        //execute
        $request->execute();
        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);
        //return object
        return $result;
    }
}
?>
<?php
namespace OnRoute\models;
class Meal{
    //DATABASE CONNECTION

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //DATABASE METHODS

    //get meals 
    public function getMeals()
    {
        $query = "SELECT * FROM flightmeals WHERE 1";

        $request = $this->db->prepare($query);

        $request->execute();

        $result = $request->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function getMealById($mealId){

        $query = "SELECT meal FROM flightmeals WHERE id = :mealId";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':mealId', $mealId);

        //execute
        $request->execute();

        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }

    public function addMealForFlight($flightBookingId, $mealId){
        $query = "UPDATE flightbookings SET meal_id = :mealId WHERE flightbookings.id = :flightBookingId";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':mealId', $mealId);
        $request->bindParam(':flightBookingId', $flightBookingId);

        //execute
        $request->execute();

        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }
}
?>
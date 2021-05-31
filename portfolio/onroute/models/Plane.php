<?php
namespace OnRoute\models;
class Plane{
    //DATABASE CONNECTION

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //DATABASE METHODS

    //get specific flight by flight number
    public function getPlaneDetailsById($planeId)
    {
        $query = "SELECT * FROM planes WHERE planes.id = :planeId";

        $request = $this->db->prepare($query);

        //sanitize
        $request->bindParam(':planeId', $planeId);

        //execute
        $request->execute();

        //fetch result
        $result = $request->fetch(\PDO::FETCH_OBJ);

        //return object
        return $result;
    }
}
?>
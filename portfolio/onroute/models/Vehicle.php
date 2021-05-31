<?php

namespace OnRoute\models;

class Vehicle{

    //function to get all columns in the 'vehicles' table.
    public function getAllVehicles($dbcon){

        $sql = 'SELECT * FROM vehicles';

        $pdo = $dbcon->prepare($sql);
        $pdo->execute();
        $vehicles = $pdo->fetchAll(\PDO::FETCH_OBJ);

        return $vehicles;

    }
    //function to get vehicles in the 'vehicles' table by id.
    public function getVehiclesById($id, $dbcon){

        $sql = 'SELECT * FROM vehicles WHERE id = :id';
        $pdo = $dbcon->prepare($sql);
        $pdo->bindValue(':id', $id);
        $pdo->execute();
        $vehicles = $pdo->fetchAll(\PDO::FETCH_OBJ);

        return $vehicles;

    }
    //function to get rental companies in the 'rentalcompanies' table by id.
    public function getRentalCompanies($id, $dbcon){

        $sql = 'SELECT * FROM rentalcompanies WHERE id = :id';

        $pdo = $dbcon->prepare($sql);
        $pdo->bindValue(':id', $id);
        $pdo->execute();
        $rcompanies = $pdo->fetchAll(\PDO::FETCH_OBJ);

        return $rcompanies;
        
    }
    //function to get specific columns from the 'vehicalrentals' table
    //function to get specific vehicles from vehicles table that match search
    public function SpecificCity($vehiclecity, $dbcon)
    {
        $sql = "SELECT * FROM vehicles WHERE vehiclecity LIKE '%$vehiclecity%'";

        $pdo = $dbcon->prepare($sql);
        $pdo->execute();
        $vrentals = $pdo->fetchAll(\PDO::FETCH_OBJ);

        return $vrentals;

    }
    //Add Vehicle Information into vehiclerentals table
    public function addVehiclesToRent($vehicleLoc, $puDate, $rDate, $vehicleid, $userid, $dbcon){

        $sql = "INSERT INTO vehiclerentals (pickuplocation, pickupdate, returndate, vehicle_id, user_id)
        VALUES (:vehicleloc, :puDate, :rDate, :vehicleid, :userid)";

        $pdo = $dbcon->prepare($sql);
        $pdo->bindParam(':vehicleloc', $vehicleLoc);
        $pdo->bindParam(':puDate', $puDate);
        $pdo->bindParam(':rDate', $rDate);
        $pdo->bindParam(':vehicleid', $vehicleid);
        $pdo->bindParam(':userid', $userid);
        $pdo->execute();
        $result =  $pdo->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
    //Delete Vehicle i=Information form the vehiclerentals table
    public function deleteVehiclesToRent($id, $dbcon){

        $sql = "DELETE FROM vehiclerentals WHERE id = :rentalId";

        $pdo = $dbcon->prepare($sql);
        $pdo->bindParam(':rentalId', $id);
        $pdo->execute();
        $result =  $pdo->fetchAll(\PDO::FETCH_OBJ);
        
        return $result;
    }
    //Get Vehicles with Pickup Dates and Return Dates that match
    public function GetSelectedDate($puDate, $rDate, $vehicleid, $dbcon){

        $sql = "SELECT * FROM vehiclerentals 
        WHERE '$puDate' BETWEEN pickupdate AND returndate AND vehicle_id = :vehicleid
        OR '$rDate' BETWEEN pickupdate AND returndate AND vehicle_id = :vehicleid";

        $pdo = $dbcon->prepare($sql);
        $pdo->bindParam(':vehicleid', $vehicleid);
        $pdo->execute();
        $result = $pdo->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function getVehicleRentalByUser($userId, $dbcon){
        $query = "SELECT vehiclemodel, vehiclemake, vehicleimage, vehicleprice, user_id, pickupdate, pickuplocation, pickupdate, returndate, rentalcompanyname, rentalcompanyaddress, vehiclerentals.id 
        FROM vehicles
        LEFT JOIN vehiclerentals ON vehicles.id = vehiclerentals.vehicle_id 
        LEFT JOIN rentalcompanies ON rentalcompanies.id = vehicles.rentalcompany_id 
        WHERE user_id = :userId";

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

    public function getVehicleRentalByBookingId($vehicleRentalId, $dbcon)
    {
        $query = "SELECT vehiclemodel, vehiclemake, vehicleimage, vehicleprice, user_id, pickupdate, pickupdate, returndate, rentalcompanyname, rentalcompanyaddress, vehiclerentals.id 
        FROM vehicles
        LEFT JOIN vehiclerentals ON vehicles.id = vehiclerentals.vehicle_id 
        LEFT JOIN rentalcompanies ON rentalcompanies.id = vehicles.rentalcompany_id 
        WHERE vehiclerentals.id = :vehicleRentalId";

        $request = $dbcon->prepare($query);

        //sanitize
        $request->bindParam(':vehicleRentalId', $vehicleRentalId);
        
        //execute
        $request->execute();

        //fetch result
        $result = $request->fetchAll(\PDO::FETCH_OBJ);

        //return object
        return $result;

    }
}
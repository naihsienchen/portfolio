<?php
namespace OnRoute\models;
use PDO;
class User{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUser($email, $pass){
        $sql = "select * from users where email = :email AND password = :pass";

        $pdostm = $this->db->prepare($sql);

        $pdostm->bindParam(':email', $email);
        $pdostm->bindParam(':pass', $pass);

        $count = $pdostm->execute();

        if ($count) {
            return $pdostm->fetch(PDO::FETCH_OBJ);
        } else {
            return null;
        }
    }
    public function addUser($email, $pass, $fname, $lname, $pnumber){
        $sql = "insert into users (password, firstname, lastname, email, phonenumber) values (:pass, :fname, :lname, :email, :pnumber)";

        $pdostm = $this->db->prepare($sql);

        $pdostm->bindParam(':pass', $pass);
        $pdostm->bindParam(':fname', $fname);
        $pdostm->bindParam(':lname', $lname);
        $pdostm->bindParam(':email', $email);
        $pdostm->bindParam(':pnumber', $pnumber);

        $count = $pdostm->execute();
        
        if ($count) {
            return 'Registration successful';
        } else {
            return 'Registration failed';
        }
    }
    public function checkIfEmailIsUnique($email){
        $sql = "select * from users where email = :email";

        $pdostm = $this->db->prepare($sql);

        $pdostm->bindParam(':email', $email);

        $pdostm->execute();

        return $pdostm->fetch(PDO::FETCH_OBJ);
    }
    public function getUserIdByEmail($email){
        $sql = "select id from users where email = :email";

        $pdostm = $this->db->prepare($sql);
        $pdostm->bindParam(':email', $email);

        $pdostm->execute();

        return $pdostm->fetch(PDO::FETCH_OBJ);
    }
    public function UpdateUserEmail($id, $email) {
        $sql = "update users set email = :email where id = :id";

        $pdostm = $this->db->prepare($sql);
        $pdostm->bindParam(':email', $email);
        $pdostm->bindParam(':id', $id);
        $pdostm->execute();
    }
    public function ChangePassword($id, $newPassword) {
        $sql = "update users set password = :pass where id = :id";

        $pdostm = $this->db->prepare($sql);
        $pdostm->bindParam(':pass', $newPassword);
        $pdostm->bindParam(':id', $id);
        $pdostm->execute();
    }
    public function getUserByEmail($email){
        $sql = "select * from users where email = :email";

        $pdostm = $this->db->prepare($sql);
        $pdostm->bindParam(':email', $email);

        $pdostm->execute();

        return $pdostm->fetch(PDO::FETCH_OBJ);
    }
}
?>
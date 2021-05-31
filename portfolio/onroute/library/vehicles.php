<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function addPrice($value, $amount){
        $price = $value*($amount+1);
        return $price;
    }
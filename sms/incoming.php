<?php
    include "../functions.php";
    //receive data from the gateway 
    $phoneNumber = $_POST['from'];
    $text = $_POST['text'];
    $textArray = explode(",", $text);
    // Check if the user is registered from incoming message 
    $conn = new OurConnection();
    $sql = "SELECT * FROM clients WHERE c_tell = '$phoneNumber'";
    $result = $conn->fetch($sql);
    if (count($result) > 0) {
        // user is registered 
        $message = "You are already registered";
        echo $message;
    } else {
        // register user from message
        // Full names,National ID,Meter Id,PIN
        // check if the user has provided all the required information
        if(count($textArray) < 4 || empty($textArray[0]) || empty($textArray[1]) || empty($textArray[2]) || empty($textArray[3])){
            $message = "Please provide all the required information in the format: Full names,National ID,Meter Id,PIN";
            echo $message;
            return;
        }
        $names = $textArray[0];
        $nid = $textArray[1];
        $meterId = $textArray[2];
        
        // check if meter id exists
        $sql = "SELECT * FROM meters WHERE meter_id = '$meterId'";
        $result = $conn->fetch($sql);
        if (count($result) == 0) {
            $message = "Meter ID does not exist";
            echo $message;
            return;
        }
        // // check if meter is already registered to other client 
        $sql = "SELECT * FROM clients WHERE meter_id = '$meterId'";
        $result = $conn->fetch($sql);
        if (count($result) > 0) {
            $message = "Meter ID is already registered to onother client";
            echo $message;
            return;
        }
        $pin = $textArray[3];
        $sql = "INSERT INTO clients (c_name, c_nid, meter_id, pin, c_tell, reg_date) 
                VALUES ('$names', '$nid', '$meterId', '$pin', '$phoneNumber', NOW())";
        $conn->exec($sql);
        // send a message to the user
        $message = "$names, You have successfully registered";
        $msg = hdev_sms::send("WATER-Ms",$phoneNumber, $message);
        echo $message;
    }
    
?>
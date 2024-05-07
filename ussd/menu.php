<?php
include_once 'util.php';
include_once "../functions.php";
    class Menu
    {
        protected $text;
        protected $sessionId;

        function __construct($text, $sessionId, $phoneNumber)
        {
            $this->text = $text;
            $this->sessionId = $sessionId;
            $this->phoneNumber = $phoneNumber;
            
        }
        // check if phone number is registered
        public function is_registered(){
            $conn = new OurConnection();
            $sql = "SELECT * FROM clients WHERE c_tell = $this->phoneNumber";
            $data = $conn->fetch($sql);
            if(count($data) == 0){
                return false;
            }else{
                return true;
            }
        }
        public function mainMenuUnregistered(){
            $response = "CON Welcome to Water Ms \n";
            $response .= "1. Perform Registration \n";
            echo $response;
        }
        public function menuRegister($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter your Full names \n";
                echo $response;
            }else if($level == 2){
                $response = "CON Enter National ID \n";
                echo $response;
            }else if($level == 3){
                $response = "CON Meter Id \n";
                echo $response;
            }else if($level == 4){
                //Check if the meter id is valid (exist in meter database)
                $meterId = $textArray[3];
                $conn = new OurConnection();
                $sql = "SELECT * FROM meters WHERE meter_id = '$meterId'";
                $data = $conn->fetch($sql);
                if(count($data) == 0){
                    $response = "END Meter Id does not exist";
                    echo $response;
                }else{
                    // check if meter is already registered to other client 
                    $sql2 = "SELECT * FROM clients WHERE meter_id = '$meterId'";
                    $data2 = $conn->fetch($sql2);
                    if(count($data2) != 0){
                        $response = "END Meter Id is already registered to another client";
                        echo $response;
                    }else{
                        //display meter info (meter name and meter owner(manufacturer))
                        $response = "CON Meter Name: ".$data[0]['meter_name']."\n";
                        $response .= "Meter Manufacturer: ".$data[0]['meter_owner']."\n";
                        $response .= "1. Confirm \n";
                        $response .= "2. Cancel \n";
                        echo $response;
                    }
                }

            }else if($level == 5){
                // if confirm is selected, as a user a pin else cancel
                if($textArray[4] == 1){
                    $response = "CON Set your PIN \n";
                    echo $response;
                }else{
                    $response = "END Thank you for using our service";
                    echo $response;
                }
            }else if($level == 6){
                $response = "CON Confirm your PIN \n";
                echo $response;
            }else if($level == 7){
                $name = $textArray[1];
                $nationalId = $textArray[2];
                $meterId = $textArray[3];
                $pin = $textArray[5];
                $confirmPin = $textArray[6];
                if ($pin != $confirmPin){
                    $response = "END Your PINs do not match, Retry";
                    echo $response;
                }else{
                    $conn = new OurConnection();
                    $sql = "INSERT INTO clients (c_name, c_nid, meter_id, pin, c_tell, reg_date) VALUES ('$name', '$nationalId', '$meterId', '$pin', $this->phoneNumber, NOW())";
                    $conn->exec($sql);
                    $response = "END $textArray[1], You have successfully registered";
                    $number = $this->phoneNumber;
                    $msg = "Dear ".$name.", You have successfully registered with WATER MS";
                    hdev_sms::send("WATER-Ms",$number,$msg);
                    echo $response;
                }
            }
            

        }
        
        // main menu registered 1.send money, 2. withdraw money, 3. check balance 
        public function mainMenuRegistered(){
            $response = "CON Welcome back to WATER MS \n";
            $response .= "1. Record Meter status \n";
            $response .= "2. Check Meter Balance \n";
            $response .= "3. Make Payment \n";

            echo $response;
        }
        // check meter balance ask for meter id and pin
        public function menuCheckBalance($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter your Meter ID \n";
                echo $response;
            }else if($level == 2){
                $response = "CON Enter your PIN \n";
                echo $response;
            }else if($level == 3){
                $meterId = $textArray[1];
                $pin = $textArray[2];
                $conn = new OurConnection();
                $sql = "SELECT * FROM clients WHERE meter_id = '$meterId' AND pin = '$pin'";
                $data = $conn->fetch($sql);
                if(count($data) == 0){
                    $response = "END Invalid Meter ID or PIN";
                    echo $response;
                }else{
                    // check if phonenumber is allowed to check balance (if number in db = number of user)
                    if($data[0]['c_tell'] != $this->phoneNumber){
                        $response = "END You are not allowed to check balance for this meter";
                        echo $response;
                    }else{

                        // display client name , meter id and its balance from db 
                        // client name 
                        $response = "CON Client Name: ".$data[0]['c_name']."\n";
                        $response .= "Meter ID: ".$data[0]['meter_id']."\n";
                        // balanec will be from `water_usage_unpaid`(`meter_id`, `total_m3_usage_unpaid`, `remaining_amount_to_pay`)
                        $sql = "SELECT * FROM water_usage_unpaid WHERE meter_id = '$meterId'";
                        $data = $conn->fetch($sql);
                        // m3 remaining unpaid 
                        $response .= "Total m3 usage unpaid: ".$data[0]['total_m3_usage_unpaid']."\n";
                        $response .= "Balance: ".$data[0]['remaining_amount_to_pay']."\n";

                        // $response .= "Balance: ".$data[0]['balance']."\n";
                        $response .= Util::$GO_BACK.". Go Back \n";
                        $response .= Util::$GO_TO_MAIN_MENU.". Main Menu \n";
                        echo $response;
                    }

                }
            }
        }

        // record meter status, by meter_id pin and meter_reading ; pin to be checked before inserting the reading; check pin and meter_id on level 2 
        public function menuRecordMeterStatus($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter your Meter ID \n";
                echo $response;
            }else if($level == 2){
                $response = "CON Enter your PIN \n";
                echo $response;
            }else if($level == 3){
                $meterId = $textArray[1];
                $pin = $textArray[2];
                $conn = new OurConnection();
                $sql = "SELECT * FROM clients WHERE meter_id = '$meterId' AND pin = '$pin'";
                $data = $conn->fetch($sql);
                if(count($data) == 0){
                    $response = "END Invalid Meter ID or PIN";
                    echo $response;
                }else{
                    // check if phonenumber is allowed to check balance (if number in db = number of user)
                    if($data[0]['c_tell'] != $this->phoneNumber){
                        $response = "END You are not allowed to access data for this meter";
                        echo $response;
                    }else{
                        // $response = "CON Enter Meter Reading \n";
                        // get client data from meter_id
                        $response = "CON Client Name: ".$data[0]['c_name']."\n";
                        $response .= "Meter ID: ".$data[0]['meter_id']."\n";
                        $response .= "Enter Meter Reading \n";
                        echo $response;
                    }

                }
            }else if($level == 4){
                $meterId = $textArray[1];
                $pin = $textArray[2];
                $meterReading = $textArray[3];
                // meter_reading must be decimal number 
                if(!is_numeric($meterReading)){
                    $response = "END Meter reading must be a number";
                    echo $response;
                    return;
                }
                // meter reading must be greater or equal to the previous record
                $conn = new OurConnection();
                $sql = "SELECT * FROM meter_logs WHERE meter_id = '$meterId' ORDER BY meter_log_date DESC LIMIT 1";
                $data = $conn->fetch($sql);
                if(count($data) != 0){
                    if($meterReading < $data[0]['meter_reading']){
                        $response = "END Meter reading must be greater than the previous reading";
                        echo $response;
                        return;
                    }
                }
                // insert meter reading into meter_logs table
                $conn = new OurConnection();
                $sql = "INSERT INTO meter_logs (meter_reading, meter_log_date, meter_id) VALUES ('$meterReading', NOW(), '$meterId')";
                $conn->exec($sql);
                $sql = "SELECT * FROM clients WHERE meter_id = '$meterId' AND pin = '$pin'";
                $data = $conn->fetch($sql);
                $response = "END ".$data[0]['c_name'].", Your meter reading of ".$meterReading." has been recorded successfully";
                $number = $this->phoneNumber;
                $msg = "Dear ".$data[0]['c_name'].", Your meter reading of ".$meterReading." has been recorded successfully";
                hdev_sms::send("WATER-Ms",$number,$msg);
                echo $response;

            }
        }
        public function menuMakePayment($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter your Meter ID \n";
                echo $response;
            }else if($level == 2){
                $response = "CON Enter your PIN \n";
                echo $response;
            }else if($level == 3){
                $meterId = $textArray[1];
                $pin = $textArray[2];
                $conn = new OurConnection();
                $sql = "SELECT * FROM clients WHERE meter_id = '$meterId' AND pin = '$pin'";
                $data = $conn->fetch($sql);
                if(count($data) == 0){
                    $response = "END Invalid Meter ID or PIN";
                    echo $response;
                }else{
                    // check if phonenumber is allowed to check balance (if number in db = number of user)
                    if($data[0]['c_tell'] != $this->phoneNumber){
                        $response = "END You are not allowed to access data for this meter";
                        echo $response;
                    }else{
                        // $response = "CON Enter Meter Reading \n";
                        // get client data from meter_id
                        $response = "CON Client Name: ".$data[0]['c_name']."\n";
                        $response .= "Meter ID: ".$data[0]['meter_id']."\n";
                        $response .= "Enter Amount Paid \n";
                        echo $response;
                    }

                }
            }else if($level == 4){
                $response = "CON Enter your Slip Number \n";
                echo $response;
            }else if($level == 5){
                $meterId = $textArray[1];
                $pin = $textArray[2];
                $amountPaid = $textArray[3];
                // slipnumber 
                $slipNumber = $textArray[4];
                // slipnumber must be unique
                $conn = new OurConnection();
                $sql = "SELECT * FROM payments WHERE payment_slip = '$slipNumber'";
                $data = $conn->fetch($sql);
                if(count($data) != 0){
                    $response = "END Slip Number already used";
                    echo $response;
                    return;
                }

                // amount paid must be decimal number 
                if(!is_numeric($amountPaid)){
                    $response = "END Amount paid must be a number";
                    echo $response;
                    return;
                }
                // get m3 price from db
                $conn = new OurConnection();
                $sql = "SELECT * FROM water_usage_unpaid WHERE meter_id = '$meterId'";
                $data = $conn->fetch($sql);
                // $m3Price = $data[0]['m3_price'];
                $dta = new Data();
                $m3Price = $dta->get_m3_price();

                $maxm3Qty = $data[0]['total_m3_usage_unpaid'];
                $m3Qty = $amountPaid / $m3Price;

                $maxPrice = $maxm3Qty * $m3Price;
                
                $totalPrice = $m3Price * $m3Qty;
                if($amountPaid > $maxPrice){
                    $response = "END Amount paid must be less than or equal to the total price";
                    echo $response;
                    return;
                }
                // insert payment into payments table
                $conn = new OurConnection();
                $sql = "INSERT INTO payments (meter_id, m3_price, m3_qty, total_price, payment_status, payment_slip, payment_date_time) VALUES ('$meterId', '$m3Price', '$m3Qty', '$totalPrice', 'paid', '$slipNumber', NOW())";
                $conn->exec($sql);
                $sql = "SELECT * FROM clients WHERE meter_id = '$meterId' AND pin = '$pin'";
                $data = $conn->fetch($sql);
                $response = "END ".$data[0]['c_name'].", Your payment of ".$amountPaid." has been recorded successfully";
                // send user message 
                // by this function hdev_sms::send("SENDER ID","TELL","MESSAGE");
                // Number $this->phoneNumber
                $number = $this->phoneNumber;
                $msg = "Dear ".$data[0]['c_name'].", Your payment of ".$amountPaid." has been recorded successfully";
                hdev_sms::send("WATER-Ms",$number,$msg);
                echo $response;
            }


        }
        
        
        
        
        
        public function middleware($text){
            return $this->goBack($this->goToMainMenu($text));
        }
        public function goBack($text){
            $explodedText = explode("*", $text);
            while(array_search(Util::$GO_BACK, $explodedText) != false){
                $firstIndex = array_search(Util::$GO_BACK, $explodedText);
                array_splice($explodedText, $firstIndex-1, 2);
            }
            return join("*", $explodedText);
        }
        public function goToMainMenu($text){
            $explodedText = explode("*", $text);
            while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) != false){
                $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
                $explodedText = array_slice($explodedText, $firstIndex+1);

            }
            return join("*", $explodedText);
        }   
    }
    
?>
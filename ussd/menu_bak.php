<?php
include_once 'util.php';
    class Menu
    {
        protected $text;
        protected $sessionId;

        function __construct($text, $sessionId)
        {
            $this->text = $text;
            $this->sessionId = $sessionId;
            
        }
        public function mainMenuUnregistered(){
            $response = "CON Welcome to XYZ MOMO \n";
            $response .= "1. Register \n";
            echo $response;
        }
        public function menuRegister($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter your full name \n";
                echo $response;
            }else if($level == 2){
                $response = "CON Set your PIN \n";
                echo $response;
            }else if($level == 3){
                $response = "CON Confirm your PIN \n";
                echo $response;
            }else if($level == 4){
                $name = $textArray[1];
                $pin = $textArray[2];
                $confirmPin = $textArray[3];
                if ($pin != $confirmPin){
                    $response = "END Your PINs do not match, Retry";
                    echo $response;
                }else{
                    $response = "END $textArray[1], You have successfully registered";
                    echo $response;
                }
            }

        }
        // main menu registered 1.send money, 2. withdraw money, 3. check balance 
        public function mainMenuRegistered(){
            $response = "CON Welcome back to XYZ MOMO \n";
            $response .= "1. Send Money \n";
            $response .= "2. Withdraw Money \n";
            $response .= "3. Check Balance \n";

            echo $response;
        }
        // send money ($textArray)
        public function menuSendMoney($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter recipient's phone number \n";
                echo $response;
            }else if($level == 2){
                $response = "CON Enter amount \n";
                echo $response;
            }else if($level == 3){
                $response = "CON Enter your PIN \n";
                echo $response;
            }
            //confirm it 
            else if($level == 4){
                $response = "CON send Frw $textArray[2] to $textArray[1] \n";
                $response .= "1. Confirm \n";
                $response .= "2. Cancel \n";
                // go to main menu from util
                $response .= Util::$GO_BACK.". Go Back \n";
                $response .= Util::$GO_TO_MAIN_MENU.". Main Menu \n";
                echo $response;
            }elseif($level == 5 && $textArray[4] == 1){
                $response = "END Your request is being processed \n";
                echo $response;
            }elseif($level == 5 && $textArray[4] == 2){
                $response = "END Thank you for using our service cancelled";
                echo $response;
            }
        }
        // withdraw money ($textArray)
        public function menuWithdrawMoney($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter amount \n";
                echo $response;
            }else if($level == 2){
                $response = "CON Enter your PIN \n";
                echo $response;
            }else if($level == 3){
                $response = "END You have successfully withdrawn Frw $textArray[1]";
                echo $response;
            }
        }
        // check balance ($textArray)
        public function menuCheckBalance($textArray){
            $level = count($textArray);
            if($level == 1){
                $response = "CON Enter your PIN \n";
                echo $response;
            }
            else if($level == 2){
                $response = "END Your balance is Frw 100,000";
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
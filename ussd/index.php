<?php
    include_once 'menu.php';
    $sessionId = $_POST['sessionId'];
    $phoneNumber = $_POST['phoneNumber'];
    $serviceCode = $_POST['serviceCode'];
    $text = $_POST['text'];

    // $isRegistered = true;
    // check if user is registered 

    $menu = new Menu($text, $sessionId, $phoneNumber);
    $text = $menu->middleware($text);
    $isRegistered = $menu->is_registered();
    
    if($text == "" && !$isRegistered){
        $menu->mainMenuUnregistered();
    }else if($text == "" && $isRegistered){
        $menu->mainMenuRegistered();
    }else if(!$isRegistered){
        $textArray = explode("*", $text);
        switch ($textArray[0]) {
            case 1:
                $menu->menuRegister($textArray);
                break;
            default:
                $response = "END Invalid input";
                echo $response;
                break;
        }
    }else{
        $textArray = explode("*", $text);
        switch ($textArray[0]) {
            case 1:
                $menu->menuRecordMeterStatus($textArray);
            break;
            case 2:
                $menu->menuCheckBalance($textArray);
                break;
            case 3:
                $menu->menuMakePayment($textArray);
                break;
            default:
                $response = "END Invalid input";
                echo $response;
                break;
        }
    }
?>
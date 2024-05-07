<?php

    session_start();
    include "sms_parse.php";
    hdev_sms::api_id("HDEV-faab0d87-ac32-458d-a033-dabc2a3f704c-ID");
    hdev_sms::api_key("HDEV-2c1859ad-3b06-4c6b-b592-dca496619384-KEY");
    //app settings class
    class AppSettings
    {
        // app name, main link properties 
        public static $app_name = "Water Ms";
        public static $app_link = "http://localhost/water_ms";
        // db properties
        public static $db_host = "localhost";
        public static $db_name = "water_ms";
        public static $db_user = "root";
        public static $db_pass = "";
        // currency
        public static $currency = "Frw";
        //constructor
        function __construct()
        {
            // code...
        }
        // redirect function based on the applink 
        public static function redirect($page){
            // use js redirect 
            echo "<script>window.location.href='".self::$app_link."/".$page."'</script>";
            exit();
        }
        // redirect withmessage 
        public static function redirectWithMessage($page, $message){
            // use js redirect 
            echo "<script>alert('".$message."'); window.location.href='".self::$app_link."/".$page."'</script>";
            exit();
        }
        // Money function 
        public static function money($amount){
            return self::$currency." ".number_format($amount, 2);
        }

    }
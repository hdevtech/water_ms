<?php
    include_once "app_settings.php";
    class OurConnection
    {
        public $conn;
        //pdo conn constructor 
        public function __construct()
        {
            // $this->conn = new PDO("mysql:host=localhost;dbname=crud", "root", "");
            $this->conn = new PDO("mysql:host=".AppSettings::$db_host.";dbname=".AppSettings::$db_name, AppSettings::$db_user, AppSettings::$db_pass);
        }
        //insert function

        public function exec($sql)
        {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        }
        //fetch function
        public function fetch($sql)
        {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

    }

    // Data class 
    class Data
    {
        public $conn;
        //pdo conn constructor 
        public function __construct()
        {
            $this->conn = new OurConnection();
        }
        // get the price from get_m3_price() database function on db engine 
        public function get_m3_price(){
            $sql = "SELECT get_m3_price() as price";
            $data = $this->conn->fetch($sql);
            return $data[0]['price'];
        }
        public function update_m3_price($price) {
            $sql = "CREATE OR REPLACE FUNCTION get_m3_price() RETURNS DECIMAL(10, 2)
                    BEGIN
                        DECLARE price DECIMAL(10, 2);
                        SET price = $price;
                        RETURN price;
                    END";
        
            $this->conn->exec($sql);
        }

        
    }

?>
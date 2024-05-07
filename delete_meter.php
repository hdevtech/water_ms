<!-- delete meter -->
<?php
    require_once 'functions.php';
    $conn = new OurConnection();
    $meter_id = $_GET['meter_id'];
    $sql = "DELETE FROM meters WHERE meter_id = $meter_id";
    $conn->exec($sql);
    header("Location: index.php");
?>
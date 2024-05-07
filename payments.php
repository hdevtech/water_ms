<?php 

    include 'header.php';
    $conn = new OurConnection();
    // Payment logs data 
    // `payments`(`payment_id`, `meter_id`, `m3_price`, `m3_qty`, `total_price`, `payment_status`, `payment_slip`, `payment_date_time`) join with `clients`(`c_id`, `meter_id`, `c_tell`, `c_name`, `c_nid`, `pin`, `reg_date`)
    $sql = "SELECT * FROM `payments` JOIN `clients` ON payments.meter_id = clients.meter_id";

?>
<!-- main content -->
<div class="" id ="layoutSidenav_content">
    <main>
  <div class="container-fluid row justify-content-center px-4">
    <h1 class="mt-4">Payment History</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Payment History</li>
    </ol>
    <div class="col-md-12">
        <table class="table table-striped table-bordered" id="datatablesSimple">
            <thead>
                <tr>
                    <th scope="col">Payment ID</th>
                    <th scope="col">Client Name</th>
                    <th scope="col">Client Phone</th>
                    <th scope="col">Meter ID</th>
                    <th scope="col">M3 Price</th>
                    <th scope="col">M3 Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Payment Slip</th>
                    <th scope="col">Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $result = $conn->fetch($sql);
                    if (count($result) > 0) {
                        foreach($result as $row) {
                            echo "<tr>";
                            echo "<td>".$row['payment_id']."</td>";
                            echo "<td>".$row['c_name']."</td>";
                            echo "<td>".$row['c_tell']."</td>";
                            echo "<td>".$row['meter_id']."</td>";
                            echo "<td>".$row['m3_price']."</td>";
                            echo "<td>".$row['m3_qty']." m<sup>3</sup></td>";
                            echo "<td>".$row['total_price']."</td>";
                            echo "<td>".$row['payment_status']."</td>";
                            echo "<td>".$row['payment_slip']."</td>";
                            echo "<td>".$row['payment_date_time']."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                ?>
            </tbody>
        </table>
    </div>
    </div>
</main>
<!-- footer -->
<?php include "footer.php" ?>
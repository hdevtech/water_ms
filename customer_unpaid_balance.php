<?php 

    include 'header.php';
    $conn = new OurConnection();
    // customer unpaid bills
    //  `water_usage_unpaid`(`meter_id`, `total_m3_usage_unpaid`, `remaining_amount_to_pay`) join with `clients`(`c_id`, `meter_id`, `c_tell`, `c_name`, `c_nid`, `pin`, `reg_date`)
    $sql = "SELECT * FROM `payments` JOIN `clients` ON payments.meter_id = clients.meter_id";
    $sql2 = "SELECT * FROM `water_usage_unpaid` JOIN `clients` ON water_usage_unpaid.meter_id = clients.meter_id";

?>
<!-- main content -->
<div class="" id ="layoutSidenav_content">
    <main>
  <div class="container-fluid row justify-content-center px-4">
    <h1 class="mt-4">Customer Unpaid Balance</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Customer Unpaid Balance</li>
    </ol>
    <div class="col-md-12">
        <table class="table table-striped table-bordered" id="datatablesSimple">
            <thead>
                <tr>
                    <th scope="col">Client Name</th>
                    <th scope="col">Client Phone</th>
                    <th scope="col">Meter ID</th>
                    <th scope="col">Total M3 Usage Unpaid</th>
                    <th scope="col">Remaining Amount to Pay</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $result = $conn->fetch($sql2);
                    if (count($result) > 0) {
                        foreach($result as $row) {
                            echo "<tr>";
                            echo "<td>".$row['c_name']."</td>";
                            echo "<td>".$row['c_tell']."</td>";
                            echo "<td>".$row['meter_id']."</td>";
                            echo "<td>".$row['total_m3_usage_unpaid']." m<sup>3</sup></td>";
                            echo "<td>".$row['remaining_amount_to_pay']."</td>";
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
<?php include 'footer.php'; ?>
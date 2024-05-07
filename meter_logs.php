<?php 

    include 'header.php';
    $conn = new OurConnection();
    // Meter logs data 
    // `meter_logs`(`meter_log_id`, `meter_reading`, `meter_log_date`, `meter_id`)
    // Join clients table to get the client name
    // `clients`(`c_id`, `meter_id`, `c_tell`, `c_name`, `c_nid`, `pin`, `reg_date`)
    $sql = "SELECT meter_logs.meter_log_id, meter_logs.meter_reading, meter_logs.meter_log_date, clients.c_name FROM meter_logs INNER JOIN clients ON meter_logs.meter_id = clients.meter_id ORDER BY meter_logs.meter_log_date DESC";
    $meter_logs = $conn->fetch($sql);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Meter Logs</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Meter Logs</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-bordered" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">Meter Log ID</th>
                                <th scope="col">Meter Reading</th>
                                <th scope="col">Meter Log Date</th>
                                <th scope="col">Client Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($meter_logs as $log) {
                                    echo "<tr>";
                                    echo "<td>".$log['meter_log_id']."</td>";
                                    echo "<td>".$log['meter_reading']." m<sup>3</sup></td>";
                                    echo "<td>".$log['meter_log_date']."</td>";
                                    echo "<td>".$log['c_name']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
<?php include 'footer.php'; ?>
    

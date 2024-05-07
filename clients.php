
<?php 
include "header.php";

    $conn = new OurConnection();
    $clients = $conn->fetch("SELECT * FROM clients");
?>
<div class="" id ="layoutSidenav_content">
    <main>
  <div class="container-fluid row justify-content-center px-4">
    <h1 class="mt-4">Meter Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Meter Data</li>
    </ol>
            <div class="col-md-10">
                <?php if (!empty($clients)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Client ID</th>
                                <th scope="col">Meter ID</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">National ID</th>
                                <th scope="col">Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?php echo $client['c_id']; ?></td>
                                    <td><?php echo $client['meter_id']; ?></td>
                                    <td><?php echo $client['c_tell']; ?></td>
                                    <td><?php echo $client['c_name']; ?></td>
                                    <td><?php echo $client['c_nid']; ?></td>
                                    <td><?php echo $client['reg_date']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No client data available.</p>
                <?php endif; ?>
            </div>
                </main>
<?php include "footer.php" ?>
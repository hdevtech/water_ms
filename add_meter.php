<?php 
include "header.php";

  $conn = new OurConnection();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meterName = $_POST['meterName'];
    $meterOwner = $_POST['meterOwner'];
    $sql = "INSERT INTO meters (meter_name, meter_owner) VALUES ('$meterName', '$meterOwner')";
    $conn->exec($sql);
    //redirect to index.php
    // header('Location: index.php');
    AppSettings::redirectWithMessage("meter_data.php", "Meter registered successfully");
  }
?>
<div class="" id ="layoutSidenav_content">
    <main>
  <div class="container-fluid row justify-content-center px-4">
    <h1 class="mt-4">Meter Registration</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Meter Registration</li>
    </ol>
    <div class="col-md-6">
      <form id="meterRegistrationForm" method="POST">
        <div class="form-group">
          <label for="meterId">Meter ID</label>
          <input type="text" class="form-control" id="meterId" name="meterId" value="AUTO" readonly>
        </div>
        <div class="form-group">
          <label for="meterName">Meter Name</label>
          <input type="text" class="form-control" id="meterName" name="meterName" required>
        </div>
        <div class="form-group">
          <label for="meterOwner">Meter Owner(company)</label>
          <input type="text" class="form-control" id="meterOwner" name="meterOwner" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </div>
</main>
<?php include "footer.php" ?>
<!-- Edit meter -->
<?php include "header.php" ?>
<?php
    require_once 'functions.php';
    $conn = new OurConnection();
    $meter_id = $_GET['meter_id'];
    $meter = $conn->fetch("SELECT * FROM meters WHERE meter_id = $meter_id");
    if (isset($_POST['submit'])) {
        $meter_name = $_POST['meter_name'];
        $meter_owner = $_POST['meter_owner'];
        $sql = "UPDATE meters SET meter_name = '$meter_name', meter_owner = '$meter_owner' WHERE meter_id = $meter_id";
        $conn->exec($sql);
        AppSettings::redirectWithMessage("meter_data.php", "Meter updated successfully");
    }
?>
<div class="" id ="layoutSidenav_content">
    <main>
  <div class="container-fluid row justify-content-center px-4">
    <h1 class="mt-4">Edit Meter Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Meter Data</li>
    </ol>
            <div class="col-md-6">
                <h2 class="mb-4">Edit Meter</h2>
                <form action="" method="post">
                    <div class="form-group">
                    <label for="meter_name">Meter Name</label>
                    <input type="text" class="form-control" id="meter_name" name="meter_name" value="<?php echo $meter[0]['meter_name']; ?>">
                    </div>
                    <div class="form-group">
                    <label for="meter_owner">Meter Owner</label>
                    <input type="text" class="form-control" id="meter_owner" name="meter_owner" value="<?php echo $meter[0]['meter_owner']; ?>">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
</main>
<?php include "footer.php" ?>
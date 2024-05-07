<!-- pricing /m3 page a page which display current m3 price and have a field to modify it -->
<!-- header -->
<?php 
    include "header.php";
    // detect if someting is submitted to update the price
    if(isset($_POST['meterName'])){
        $price = $_POST['meterName'];
        $data =  new Data();
        $data->update_m3_price($price);
        AppSettings::redirectWithMessage("pricing.php", "Price updated successfully");
    }

?>

<!-- main content -->
<div class="" id ="layoutSidenav_content">
    <main>
  <div class="container-fluid row justify-content-center px-4">
    <h1 class="mt-4">Pricing</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Pricing</li>
    </ol>
    <div class="col-md-6">
        <!-- <div class="form-group">
          <label for="meterId">Current Price per m3</label>
          <input type="text" class="form-control" id="meterId" name="meterId" value="AUTO" readonly>
        </div> -->
        <!-- display current price in a card  -->
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Current Price per m3</h5>
            <?php
                $data =  new Data();
                // get the price from Data class 
                $price = $data->get_m3_price();
                // format money 
                $amount = AppSettings::money($price);
            ?>
            <p class="card-text"><?php echo $amount; ?></p>
          </div>
        </div>
    </div>
    <div class="col-md-6">
        <form id="meterRegistrationForm" method="POST">
            <div class="form-group">
            <label for="meterName">New Price per m3</label>
            <input type="text" class="form-control" id="meterName" name="meterName" placeholder="New Price" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    </div>
</main>
<!-- footer -->
<?php include "footer.php" ?>
<?php include "header.php" ?>
<div class="" id ="layoutSidenav_content">
    <main>
  <div class="container-fluid row justify-content-center px-4">
    <h1 class="mt-4">Meter Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Meter Data</li>
    </ol>
    <div class="col-md-10">
      <?php if (!empty($meters)): ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Meter ID</th>
              <th scope="col">Meter Name</th>
              <th scope="col">Meter Owner</th>
              <!-- action -->
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($meters as $meter): ?>
              <tr>
                <td><?php echo $meter['meter_id']; ?></td>
                <td><?php echo $meter['meter_name']; ?></td>
                <td><?php echo $meter['meter_owner']; ?></td>
                <!-- action -->
                <td>
                  <a href="edit_meter.php?meter_id=<?php echo $meter['meter_id']; ?>" class="btn btn-sm
                  btn-primary">Edit</a>
                  <a href="delete_meter.php?meter_id=<?php echo $meter['meter_id']; ?>" class="btn btn-sm
                  btn-danger">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No meter data available.</p>
      <?php endif; ?>
    </div>
  </div>
  </main>

<?php include "footer.php" ?>
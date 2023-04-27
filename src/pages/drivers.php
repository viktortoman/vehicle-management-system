<?php
require '../../vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Driver;

$driverClass = new Driver();

if (isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];

    $driver = $driverClass->findById($deleteId);

    if (!$driver) {
        exit('Driver not found with this id: ' . $deleteId);
    }

    $driverClass->delete($deleteId);
    header("Location: drivers.php?msg=delete-success");
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<body>
<?php include 'menu.php'; ?>
<div class="container">
    <?php
    $msg = $_GET['msg'] ?? null;

    if ($msg == "insert-success") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Driver added successfully.
            </div>";
    }

    if ($msg == "update-success") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Driver updated successfully.
            </div>";
    }

    if ($msg == "delete-success") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Driver deleted successfully.
            </div>";
    }
    ?>
  <h2>
    Drivers
    <a href="driver/create.php" class="btn btn-primary" style="float:right;">Add new driver</a>
  </h2>
  <table class="table table-hover">
    <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Birth date</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $drivers = $driverClass->getAll();

    if (!$drivers) {
        ?>
    <tr>
      <td>No result.</td>
    </tr>
    <?php } ?>
    <?php foreach ($drivers as $driver) {
        ?>
      <tr>
        <td><?php echo $driver['id'] ?></td>
        <td><?php echo $driver['name'] ?></td>
        <td><?php echo $driver['birth_date'] ?></td>
        <td><?php echo $driver['created_at'] ?></td>
        <td>
          <a href="driver/edit.php?editId=<?php echo $driver['id'] ?>" class="text-decoration-none text-success mr-2">
            <i class="fa fa-pencil" aria-hidden="true"></i>
          </a>
          <a href="driver/assign-vehicle.php?driverId=<?php echo $driver['id'] ?>" class="text-decoration-none text-primary mr-2">
            <i class="fa fa-car" aria-hidden="true"></i>
          </a>
          <a href="drivers.php?deleteId=<?php echo $driver['id'] ?>" class="text-danger"
             onclick="confirm('Are you sure want to delete this record?')">
            <i class="fa fa-trash" aria-hidden="true"></i>
          </a>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
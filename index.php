<?php
require 'vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Vehicle;

$vehicleClass = new Vehicle();

if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];

    $vehicle = $vehicleClass->findById($deleteId);

    if (!$vehicle) {
        exit('Vehicle not found with this id: ' . $deleteId);
    }

    $vehicleClass->delete($deleteId);
    header("Location: index.php?msg=delete-success");
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'src/pages/header.php'; ?>
<body>
<?php include 'src/pages/menu.php'; ?>
<div class="container">
    <?php
    $msg = $_GET['msg'] ?? null;

    if ($msg == "insert-success") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Vehicle added successfully.
            </div>";
    }

    if ($msg == "update-success") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Vehicle updated successfully.
            </div>";
    }

    if ($msg == "delete-success") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Vehicle deleted successfully.
            </div>";
    }
    ?>
  <h2>
    Vehicles
    <a href="src/pages/vehicle/create.php" class="btn btn-primary" style="float:right;">Add new vehicle</a>
  </h2>
  <table class="table table-hover">
    <thead>
    <tr>
      <th>Id</th>
      <th>Type</th>
      <th>Vehicle type</th>
      <th>Plate number</th>
      <th>Placing on the market</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $vehicles = $vehicleClass->getAll();

    if (!$vehicles) {
    ?>
    <tr>
      <td>No result.</td>
    </tr>
    <?php } ?>

    <?php foreach ($vehicles as $vehicle) {
        ?>
      <tr>
        <td><?php echo $vehicle->getId() ?></td>
        <td><?php echo $vehicle->getLabel() ?></td>
        <td><?php echo $vehicle->getVehicleTypeLabel() ?></td>
        <td><?php echo $vehicle->getPlateNumber() ?></td>
        <td><?php echo $vehicle->getPlacingOnTheMarket() ?></td>
        <td><?php echo $vehicle->getCreatedAt() ?></td>
        <td>
          <a href="src/pages/vehicle/edit.php?editId=<?php echo $vehicle->getId() ?>" class="text-decoration-none text-success mr-2">
            <i class="fa fa-pencil" aria-hidden="true"></i>
          </a>
          <a href="index.php?deleteId=<?php echo $vehicle->getId() ?>" class="text-danger"
             onclick="confirm('Are you sure want to delete this record?')">
            <i class="fa fa-trash" aria-hidden="true"></i>
          </a>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<?php include 'src/pages/footer.php'; ?>
</body>
</html>
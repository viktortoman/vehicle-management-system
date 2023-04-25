<?php
require 'vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Vehicle;

$vehicleClass = new Vehicle();

if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];
    $vehicleClass->delete($deleteId);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'src/pages/header.php'; ?>
<body>
<div class="card text-center" style="padding:15px;">
  <h4>Vehicle management system</h4>
</div>
<br><br>
<div class="container">
    <?php
    if (isset($_GET['msg1']) == "insert") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Vehicle added successfully.
            </div>";
    }
    if (isset($_GET['msg2']) == "update") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Vehicle updated successfully.
            </div>";
    }
    if (isset($_GET['msg3']) == "delete") {
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
      <th>Plate number</th>
      <th>Placing on the market</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $vehicles = $vehicleClass->getAll();

    foreach ($vehicles as $vehicle) {
        ?>
      <tr>
        <td><?php echo $vehicle['id'] ?></td>
        <td><?php echo $vehicle['type'] ?></td>
        <td><?php echo $vehicle['plate_number'] ?></td>
        <td><?php echo $vehicle['placing_on_the_market'] ?></td>
        <td><?php echo $vehicle['created_at'] ?></td>
        <td>
          <a href="src/pages/vehicle/edit.php?editId=<?php echo $vehicle['id'] ?>" style="color:green">
            <i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp
          <a href="index.php?deleteId=<?php echo $vehicle['id'] ?>" style="color:red"
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
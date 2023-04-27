<?php
require '../../../vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Vehicle;

$vehicleClass = new Vehicle();
$vehicle = null;
$id = null;

if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $id = $_GET['editId'];
    $vehicle = $vehicleClass->findById($id);

    if (!$vehicle) {
        exit('Vehicle not found with this id: ' . $id);
    }
} else {
    exit('editId is required parameter!');
}

if (isset($_POST['save'])) {
    try {
        $vehicleClass->create($_POST);
    } catch (Exception $e) {
        exit($e);
    }

    header("Location: ../../../index.php?msg=insert-success");
}

if (isset($_POST['update'])) {
    $vehicleClass->update($id, $_POST);
    header("Location: ../../../index.php?msg=update-success");
}
?>

<form method="POST">
  <div class="form-group">
    <label for="type">Type:</label>
    <select name="type" id="type" class="form-control" required>
      <option value="car">Car</option>
      <option value="van">Van</option>
      <option value="large_truck">Large truck</option>
    </select>
  </div>

  <div class="form-group">
    <label for="plate_number">Plate number:</label>
    <input type="text" class="form-control" name="plate_number"
           placeholder="Enter plate number" value="<?php echo $vehicle ? $vehicle['plate_number'] : ''; ?>" required>
  </div>

  <div class="form-group">
    <label for="placing_on_the_market">Placing on the market:</label>
    <input type="date" class="form-control" name="placing_on_the_market"
           placeholder="Enter placing on the market" value="<?php echo $vehicle ? $vehicle['placing_on_the_market'] : ''; ?>" required>
  </div>

  <input type="submit" name="<?php echo $vehicle ? 'update' : 'save'; ?>" class="btn btn-primary float-right"
         value="<?php echo $vehicle ? 'Update' : 'Save'; ?>">
</form>

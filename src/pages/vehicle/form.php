<?php
require '../../../vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Vehicle;

$vehicleClass = new Vehicle();
$vehicle = null;
$id = null;

if (isset($_GET['editId']) && !empty($_GET['editId'])) {
    $id = $_GET['editId'];
    $vehicle = $vehicleClass->findById($id);

    if (!$vehicle) {
        exit('Vehicle not found with this id: ' . $id);
    }
}

if (isset($_POST['save'])) {
    $validateError = false;

    if ($numberOfPersons = $_POST['number_of_persons']) {
        $range = array('min_range' => 2, 'max_range' => 8);
        $options = array('options' => $range);

        if ($numberOfPersons < 2 || $numberOfPersons > 8) {
            $validateError = true;
            header("Location: create.php?msg=number-of-persons-validation-error");
        }
    }

    if ($maximumWeightOfLoad = $_POST['maximum_weight_of_load']) {
      if ($maximumWeightOfLoad > 16000) {
          $validateError = true;
          header("Location: create.php?msg=maximum-weight-of-load-validation-error");
      }
    }

    if (!$validateError) {
        try {
            $vehicleClass->create($_POST);
        } catch (Exception $e) {
            exit($e);
        }

        header("Location: ../../../index.php?msg=insert-success");
    }
}

if (isset($_POST['update'])) {
    $vehicleClass->update($id, $_POST);
    header("Location: ../../../index.php?msg=update-success");
}
?>

<form method="POST">
    <?php
    $msg = $_GET['msg'] ?? null;

    if ($msg == "number-of-persons-validation-error") {
        echo "<div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Number of persons must be between 2 and 8!
            </div>";
    }

    if ($msg == "maximum-weight-of-load-validation-error") {
        echo "<div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              The maximum weight limit is 16,000 kg!
            </div>";
    }
    ?>

  <div class="form-group">
    <label for="type">Type:</label>
    <input type="text" class="form-control" name="type"
           placeholder="Enter type" value="<?php echo $vehicle ? $vehicle->getType() : ''; ?>" required>
  </div>

  <div class="form-group">
    <label for="vehicle_type">Vehicle type:</label>
    <select name="vehicle_type" id="vehicle_type" class="form-control" required>
      <option value="car" <?php echo $vehicle && $vehicle->getVehicleType() === 'car' ? 'selected' : ''; ?>>Car</option>
      <option value="van" <?php echo $vehicle && $vehicle->getVehicleType() === 'van' ? 'selected' : ''; ?>>Van</option>
      <option
        value="large_truck" <?php echo $vehicle && $vehicle->getVehicleType() === 'large_truck' ? 'selected' : ''; ?>>
        Large truck
      </option>
    </select>
  </div>

  <div class="form-group">
    <label for="plate_number">Plate number:</label>
    <input type="text" class="form-control" name="plate_number"
           placeholder="Enter plate number" value="<?php echo $vehicle ? $vehicle->getPlateNumber() : ''; ?>" required>
  </div>

  <div class="form-group">
    <label for="placing_on_the_market">Placing on the market:</label>
    <input type="date" class="form-control" name="placing_on_the_market"
           placeholder="Enter placing on the market"
           value="<?php echo $vehicle ? $vehicle->getPlacingOnTheMarket() : ''; ?>" required>
  </div>

  <div class="form-group">
    <label for="number_of_persons">Number of persons (car):</label>
    <input type="text" class="form-control" name="number_of_persons" min="2" max="8"
           placeholder="Enter number of persons"
           value="<?php echo $vehicle && $vehicle->getVehicleType() === 'car' ? $vehicle->getNumberOfPersons() : ''; ?>">
  </div>

  <div class="form-group">
    <label for="maximum_weight_of_load">Maximum weight of load (van or truck) kg:</label>
    <input type="text" class="form-control" name="maximum_weight_of_load"
           placeholder="Enter maximum weight of load"
           value="<?php echo $vehicle && $vehicle->getVehicleType() !== 'car' ? $vehicle->getMaximumWeightOfLoad() : ''; ?>">
  </div>

  <input type="submit" name="<?php echo $vehicle ? 'update' : 'save'; ?>" class="btn btn-primary float-right"
         value="<?php echo $vehicle ? 'Update' : 'Save'; ?>">
</form>

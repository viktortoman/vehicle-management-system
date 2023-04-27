<?php
require '../../../vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Driver;
use App\VehicleManagementSystem\Classes\Vehicle;

$driverClass = new Driver();
$vehicleClass = new Vehicle();

$driverAssign = null;
$driverId = null;

$vehicles = $vehicleClass->getAll();

if(isset($_GET['driverId']) && !empty($_GET['driverId'])) {
    $driverId = $_GET['driverId'];
    $driver = $driverClass->findById($driverId);

    if (!$driver) {
        exit('Driver not found with this id: ' . $driverId);
    }
} else {
  exit('driverId is required parameter!');
}

if (isset($_POST['assign'])) {
    try {
        $driverClass->assignVehicle($_POST);
    } catch (Exception $e) {
      exit($e);
    }

    header("Location: assign-vehicle.php?driverId=$driverId&msg=assign-success");
}
?>

<form method="POST">
  <input type="hidden" name="driver_id" value="<?php echo $driverId ?>">

  <div class="form-group">
    <label for="vehicle_id">Vehicle:</label>
    <select name="vehicle_id" id="vehicle_id" class="form-control" required>
        <?php foreach ($vehicles as $vehicle) { ?>
          <option value="<?php echo $vehicle['id'] ?>"><?php echo $vehicle['label'] ?></option>
        <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="day">Date:</label>
    <input type="date" class="form-control" name="day"
           placeholder="Enter selected date" required />
  </div>

  <input type="submit" name="assign" class="btn btn-primary float-right"
         value="Assign" />
</form>

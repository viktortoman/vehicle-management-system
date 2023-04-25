<?php
require '../../../vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Vehicle;

$vehicleClass = new Vehicle();
$vehicle = null;
$id = null;

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $vehicle = $vehicleClass->findById($id);
}

if (isset($_POST['save'])) {
    $vehicleClass->create($_POST);
} else {
    $vehicleClass->update($id, $_POST);
}

?>

<form method="POST">
  <div class="form-group">
    <label for="name">Plate number:</label>
    <input type="text" class="form-control" name="name" placeholder="Enter plate number" value="<?php echo $vehicle ? $vehicle['plate_number'] : ''; ?>" required>
  </div>
  <input type="submit" name="<?php echo $vehicle ? 'update' : 'save'; ?>" class="btn btn-primary" style="float:right;" value="<?php echo $vehicle ? 'Update' : 'Save'; ?>">
</form>

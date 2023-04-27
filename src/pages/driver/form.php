<?php
require '../../../vendor/autoload.php';

use App\VehicleManagementSystem\Classes\Driver;

$driverClass = new Driver();
$driver = null;
$id = null;

if (isset($_GET['editId']) && !empty($_GET['editId'])) {
    $id = $_GET['editId'];
    $driver = $driverClass->findById($id);

    if (!$driver) {
        exit('Driver not found with this id: ' . $id);
    }
}

if (isset($_POST['save'])) {
    try {
        $driverClass->create($_POST);
    } catch (Exception $e) {
        exit($e);
    }

    header("Location: ../drivers.php?msg=insert-success");
}

if (isset($_POST['update'])) {
    $driverClass->update($id, $_POST);
    header("Location: ../drivers?msg=update-success");
}
?>

<form method="POST">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name"
           placeholder="Enter name" value="<?php echo $driver ? $driver->getName() : ''; ?>" required>
  </div>

  <div class="form-group">
    <label for="birth_date">Birth date:</label>
    <input type="date" class="form-control" name="birth_date"
           placeholder="Enter birth date" value="<?php echo $driver ? $driver->getBirthDate() : ''; ?>" required>
  </div>

  <div class="form-group">
    <label for="vehicle_type">Driving licence:</label>
    <select name="driving_licence" id="driving_licence" class="form-control" required>
      <option value="B" <?php echo $driver && $driver->getDrivingLicence() === 'B' ? 'selected' : ''; ?>>Car</option>
      <option value="C" <?php echo $driver && $driver->getDrivingLicence() === 'C' ? 'selected' : ''; ?>>Van</option>
      <option value="D" <?php echo $driver && $driver->getDrivingLicence() === 'D' ? 'selected' : ''; ?>>Large truck</option>
    </select>
  </div>

  <input type="submit" name="<?php echo $driver ? 'update' : 'save'; ?>" class="btn btn-primary float-right"
         value="<?php echo $driver ? 'Update' : 'Save'; ?>">
</form>

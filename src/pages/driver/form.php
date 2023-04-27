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
} else {
    exit('editId is required parameter!');
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
           placeholder="Enter name" value="<?php echo $driver ? $driver['name'] : ''; ?>" required>
  </div>

  <div class="form-group">
    <label for="birth_date">Birth date:</label>
    <input type="date" class="form-control" name="birth_date"
           placeholder="Enter birth date" value="<?php echo $driver ? $driver['birth_date'] : ''; ?>" required>
  </div>

  <input type="submit" name="<?php echo $driver ? 'update' : 'save'; ?>" class="btn btn-primary float-right"
         value="<?php echo $driver ? 'Update' : 'Save'; ?>">
</form>

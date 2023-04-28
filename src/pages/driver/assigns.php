<?php
require '../../../vendor/autoload.php';

use App\VehicleManagementSystem\Classes\DriverVehicle;

$driverVehicleClass = new DriverVehicle();

if(isset($_GET['driverId']) && !empty($_GET['driverId'])) {
    $driverId = $_GET['driverId'];
} else {
    exit('driverId is required parameter!');
}

?>
<div class="mt-4">
  <h2>Assigns</h2>
  <table class="table table-hover">
    <thead>
    <tr>
      <th>Id</th>
      <th>Driver</th>
      <th>Vehicle</th>
      <th>Day</th>
      <th>Created at</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $assigns = $driverVehicleClass->getAllByDriverId($driverId);

    if (!$assigns) {
        ?>
      <tr>
        <td>No result.</td>
      </tr>
    <?php } ?>
    <?php foreach ($assigns as $assign) {
        ?>
      <tr>
        <td><?php echo $assign->getId() ?></td>
        <td><?php echo $assign->getDriver()->getName() ?></td>
        <td><?php echo $assign->getVehicle()->getLabel() ?></td>
        <td><?php echo $assign->getDay() ?></td>
        <td><?php echo $assign->getCreatedAt() ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
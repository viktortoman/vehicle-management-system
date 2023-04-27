<?php
use App\VehicleManagementSystem\Classes\Config;

$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
  <a class="navbar-brand" href="#">Vehicle management system</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
          aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?php if ($activePage === "index") {echo "active"; }?>" href="<?= Config::BASE_URL . 'index.php'?>">Vehicles</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if ($activePage === "drivers") {echo "active"; }?>" href="<?= Config::BASE_URL . 'src/pages/drivers.php'?>">Drivers</a>
      </li>
    </ul>
  </div>
</nav>
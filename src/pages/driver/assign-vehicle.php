<?php
require '../../../vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../header.php'; ?>
<body>
<?php include '../menu.php'; ?>
<div class="text-center" style="padding:15px;">
  <h4>Assigning driver to a vehicle</h4>
</div>
<br>
<div class="container">
    <?php
    $msg = $_GET['msg'] ?? null;

    if ($msg == "assign-success") {
        echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Driver assigned successfully.
            </div>";
    }
    ?>
    <?php include 'assign-form.php'; ?>
</div>
<?php include '../footer.php'; ?>
</body>
</html>

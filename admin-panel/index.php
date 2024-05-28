<?php require 'layouts/header.php'; ?>
<?php require '../config/config.php'; ?>
<?php
if (!isset($_SESSION['adminname'])) {
  echo "<script>window.location.href='" . ADMINURL . "'</script>";
}

$props = $conn->query("SELECT COUNT(*) AS num_props FROM props");
$props->execute();
$AllProps = $props->fetch(PDO::FETCH_OBJ);

$category = $conn->query("SELECT COUNT(*) AS num_category FROM categories");
$category->execute();
$AllCategories = $category->fetch(PDO::FETCH_OBJ);

$admin = $conn->query("SELECT COUNT(*) AS num_admins FROM admins");
$admin->execute();
$AllAdmins = $admin->fetch(PDO::FETCH_OBJ);
?>
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Properties</h5>
        <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
        <p class="card-text">number of properties: <?php echo $AllProps->num_props ; ?></p>

      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Categories</h5>

        <p class="card-text">number of categories: <?php echo $AllCategories->num_category; ?></p>

      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Admins</h5>

        <p class="card-text">number of admins: <?php echo $AllAdmins->num_admins; ?></p>

      </div>
    </div>
  </div>
</div>
<?php require 'layouts/footer.php'; ?>
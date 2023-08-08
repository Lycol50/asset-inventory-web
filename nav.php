<?php
$register = '<a class="nav-item nav-link" href="register_user.php">Register User</a>';
$insert_asset = '<a class="nav-item nav-link" href="insert_asset.php">Insert Asset</a>';
?>
<nav class="d-print-none navbar navbar-expand-lg navbar-dark bg-dark">
  <img src="whitehttps://em-content.zobj.net/source/joypixels/340/regional-indicator-symbol-letter-i_1f1ee.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
  <a class="navbar-brand" href="#" style="font-family: Kanit, sans-serif;">Asset Inventory System</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="/">Home</a>
      <a class="nav-item nav-link" href="assets.php">List Assets</a>
      <?php if ($_SESSION['account_type'] === "admin" || $_SESSION['account_type'] === "superadmin") { echo $insert_asset; } ?>
      <?php if ($_SESSION['account_type'] === "superadmin") { echo $register; } ?>
      <a class="nav-item nav-link" href="help.php">Help</a>
      <a class="nav-item nav-link" href="logout.php" onClick="return confirm('Do you want to Logout?')">Logout</a>
    </div>
  </div>
</nav>
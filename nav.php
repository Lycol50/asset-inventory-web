<?php
$register = '<a class="nav-item nav-link" href="register_user.php">Register User</a>';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark noprint">
  <a class="navbar-brand" href="#" style="font-family: Kanit, sans-serif;">Asset Management System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="/">Home</a>
      <a class="nav-item nav-link" href="assets.php">List Assets</a>
      <a class="nav-item nav-link" href="insert_asset.php">Insert Asset</a>
      <?php if ($_SESSION['account_type'] == 'superadmin') { echo $register; } ?>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
    </div>
  </div>
  <span class="navbar-text" style="font-family: Kanit, sans-serif;">
      
  </span>
</nav>
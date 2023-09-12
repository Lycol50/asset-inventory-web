<?php
include dirname(__FILE__, 2) . '/config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: dirname(__FILE__, 2) . 'login.php'");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CCF Alabang Inventory System (Live Prod) - Help</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="https://events.ccf.org.ph/assets/app/ccf-logos/ccf-logo-full-white-logo-size.png">
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/print/bootstrap-table-print.min.js"></script>
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Forgotting Password Guide</h1>
                <p>Here the instruction on how to reset/change your password. <b>This will require human interaction to
                        users of this system</b></p>
                <br>
                <h3>Obtaining the Password Reset Code</h3>
                <div class="alert alert-warning" role="alert">
                    <p>You must have knowledge on using MySQL/MariaDB on terminal/command-line, and/or GUI <b>OR</b> Must have knowledge on using PHPMyAdmin (it is built-in on XAMPP)</p>
                </div>
                <ol>
                    <li>Open your MySQL/MariaDB terminal/command-line, and/or GUI <b>OR</b> Open PHPMyAdmin</li>
                    <li>Open the database of this system</li>
                    <li>Open the <code>users</code> table</li>
                    <li>Find the user that you want to reset/change the password</li>
                    <li>Remember the value of the <code>id</code> column</li>
                    <li>Open the <code>password_reset</code> table</li>
                    <li>Search the id you search before from users table</li>
                    <li>Write the <code>password_reset_code</code> for that user</li>
                    <li>Hand-over to the user his password reset code, and tell that do not lose it.</li>
                </ol>
            </div>
        </div>
    </div>
</body>
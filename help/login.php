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
    <title>Asset Management System</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="white.png">
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/print/bootstrap-table-print.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <h1>Logging in to the system</h1>
            <p>Logging into the system is easy as slicing paper with sharp knife.</p>
            <br>
            <ol>
                <li>Open any of your favorite browsers, then visit the Asset Inventory System Page by <b>finding the IP Address of your Web server.</b><br>And they will greet you with this:<br><img class="img-fluid" src="imgs/1.png"></li>
                <li>Start inserting your credentials provided by your System Administrator</li>
                <li>Click the <b>Log In</b> button</li>
                <li>And you will be redirected to the <b>Dashboard</b> page</li>
            </ol>
            <br>
            <h1>Logging out of the system</h1>
            <br>
            <ol>
                <li>Click the <b>Log Out</b> button on the navigation bar<br><img class="img-fluid" src="imgs/2.png"></li>
                <li>And you will be redirected to the <b>Log In</b> page<br><img class="img-fluid" src="imgs/1.png"></li>
        </div>
    </div>
</body>
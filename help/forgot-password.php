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
    <link rel="stylesheet" href="../style.css">
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
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Forgotten Password</h1>
                <p>Please follow this guide to reset your password.</p>
                <br>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Please Read me First!</h4>
                    <p>Please try to remember the password and perform login multiple time until you got into the login.
                        <br><br> So that you can minimize time for acquring your password reset code from your System
                        Administrator.
                    </p>
                </div>
                <br>
                <ol>
                    <li>Open any of your favorite browsers, then visit the Asset Inventory System Page by <b>finding the
                            IP Address of your Web server.</b><br>And they will greet you with this:<br><img
                            class="img-fluid" src="imgs/1.png"><br></li>
                    <li>Press the <b>Forgot Password</b> button</li>
                    <li>And you will be redirected to the <b>Forgot Password</b> page<br><img class="img-fluid"
                            src="imgs/3.png"><br></li>
                    <li>Enter your Username and New Password in the form</li>
                    <li>Enter your <b>Password Reset Code</b>
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">How to get Password Reset Code</h4>
                            <p>Please approach your System Administrator, provide him your Username and they will give
                                your Password Reset Code for your account.</p>
                            <hr>
                            <p>Please keep your copy of Password Reset Code, so that you can use it again.</p>
                        </div>
                    </li>
                    <li>Click the <b>Reset Password</b> button</li>
                    <li>A Alert box will apprear, click <b>OK</b></li>
                    <li>Click the <b>Remember Password</b> to redirect to Login Page</li>
                    <li>Login to the system with your new password</li>
                </ol>
            </div>
        </div>
    </div>
</body>
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
                <h1>Registering User to the System</h1>
                <p>Clicking the <b>Register User</b> above of Navigation bar, it will go to the Register User Page</p>
                <br>
                <img class="img-fluid" src="imgs/8.png"><br>
                <br>
                <h3>Adding User to the System</h3>
                <ol>
                    <li>Insert a preferred username on <b>username box</b></li>
                    <li>Insert the <b>First Name</b> of the new user</li>
                    <li>Insert the <b>Last Name</b> of the new user</li>
                    <li>Insert the desired password for that user on <b>Password box</b></li>
                    <div class="alert alert-warning" role="alert">
                        <p>Minimum Characters for Password is 6 only, you can use alphanumeric, symbols characters</p>
                    </div>
                    <li>Insert the password again on <b>Confirm Password box</b></li>
                    <li>Select User Type for that user</li>
                    <div class="alert alert-info" role="alert">
                        <p>Here are the Permissions Table for user</p>
                        <table class="table table-striped table-bordered border-start">
                            <tr>
                                <th>Permissions</th>
                                <th>Admin</th>
                                <th>User</th>
                            </tr>
                            <tr>
                                <td>View and Print Assets</td>
                                <td>✅</td>
                                <td>✅</td>
                            </tr>
                            <tr>
                                <td>Add Asset</td>
                                <td>✅</td>
                                <td>❌</td>
                            </tr>
                            <tr>
                                <td>Edit Asset</td>
                                <td>✅</td>
                                <td>❌</td>
                            </tr>
                            <tr>
                                <td>Delete Asset</td>
                                <td>✅</td>
                                <td>❌</td>
                            </tr>
                            <tr>
                                <td>Add User</td>
                                <td>❌</td>
                                <td>❌</td>
                            </tr>
                        </table>
                    </div>
                    <li>Click <b>Register</b> button to add the user to the system</li>
                    <li>A popout will appear that the new user has been registered.</li>
                    <li>Click <b>Go to Dashboard</b> to go back to Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</body>
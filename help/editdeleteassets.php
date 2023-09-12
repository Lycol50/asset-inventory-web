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
                <h1>Editing and Deleting Asset</h1>
                <p>Here you can edit and delete the asset</p>
                <br>
                <p>Go the the <b>List Assets</b> Page and here you can perform actions</p>
                <img class="img-fluid" src="imgs/7.png"><br>
                <br>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">User Limitations</h4>
                    <p>Only the <b>Admin and SuperAdmin</b> can edit and delete the asset, the <b>User</b> can only view
                        and print the assets.</p>
                </div>
                <h3>Editing Asset into the System</h3>
                <ol>
                    <li>On the List Assets Page, Find the Asset you want to Edit</li>
                    <li>Click the <b>Edit</b> button, and it will redirect to Update Asset</li>
                    <li>Update the Asset Details</li>
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Limitations of Editing Asset Data</h4>
                        <p>When editing a Asset Data, you can't add/update any <b>documents</b>.</p>
                        <hr>
                        <p>Make sure to first gather all the required documents and upload it during adding of Asset
                            Data in the system.</p>
                    </div>
                    <li>Click the <b>Submit</b> button to update the asset into the system</li>
                    <li>And a popup will appear that the Asset has been inserted successfully, and number o files
                        uploaded.</li>
                    <li>Clicking <b>Cancel</b> will go back to dashboard and will erase any data inserted before
                        submitting</li>
                </ol>
                <h3>Deleting Asset</h3>
                <ol>
                    <li>On the List Assets Page, Find the Asset you want to Delete</li>
                    <li>Click the <b>Delete</b> button to start delete that data</li>
                    <li>Click <b>Yes</b> to confirm deleting the asset data</li>
                    <li>And the Asset has been deleted to the system</li>
                </ol>
            </div>
        </div>
    </div>
</body>